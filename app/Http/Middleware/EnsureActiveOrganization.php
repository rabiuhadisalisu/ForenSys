<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveOrganization
{
    /**
     * Ensure the authenticated user is operating inside an active organization context.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $activeOrganization = $user->activeOrganization;

        if (! $activeOrganization || ! $user->organizations()->whereKey($activeOrganization->getKey())->wherePivot('membership_status', 'active')->exists()) {
            $activeOrganization = $user->organizations()
                ->wherePivot('membership_status', 'active')
                ->orderByDesc('organization_user.is_default')
                ->orderBy('organization_user.joined_at')
                ->first();

            abort_if(! $activeOrganization, 403, 'An active organization is required to access the forensic workspace.');

            $user->forceFill([
                'active_organization_id' => $activeOrganization->getKey(),
            ])->saveQuietly();
        }

        if (function_exists('setPermissionsTeamId')) {
            setPermissionsTeamId($activeOrganization->getKey());
        }

        app()->instance('activeOrganization', $activeOrganization);
        $request->attributes->set('activeOrganization', $activeOrganization);

        return $next($request);
    }
}
