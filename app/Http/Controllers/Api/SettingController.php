<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\SystemSetting;

class SettingController extends Controller
{
    use RespondsWithApi;

    public function index()
    {
        $organizationId = app('activeOrganization')->getKey();

        return $this->successResponse(
            SystemSetting::query()
                ->where(function ($query) use ($organizationId): void {
                    $query->where('organization_id', $organizationId)
                        ->orWhereNull('organization_id');
                })
                ->orderBy('group')
                ->orderBy('key')
                ->get(),
            'Settings loaded.',
        );
    }
}
