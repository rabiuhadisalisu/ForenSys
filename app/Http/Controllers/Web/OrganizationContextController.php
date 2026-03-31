<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrganizationContextController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => ['required', 'integer'],
        ]);

        $organization = $request->user()
            ->organizations()
            ->whereKey($validated['organization_id'])
            ->wherePivot('membership_status', 'active')
            ->firstOrFail();

        $request->user()->forceFill([
            'active_organization_id' => $organization->getKey(),
        ])->saveQuietly();

        return back()->with('status', 'organization-switched');
    }
}
