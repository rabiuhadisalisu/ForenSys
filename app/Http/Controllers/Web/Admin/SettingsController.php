<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $organizationId = app('activeOrganization')->getKey();

        return view('pages.admin.settings', [
            'activeNav' => 'admin',
            'pageTitle' => 'System Settings',
            'pageDescription' => 'Tenant-specific and global settings reserved for secure workspace controls.',
            'settings' => SystemSetting::query()
                ->where(function ($query) use ($organizationId): void {
                    $query->where('organization_id', $organizationId)
                        ->orWhereNull('organization_id');
                })
                ->orderBy('group')
                ->orderBy('key')
                ->get(),
        ]);
    }
}
