<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $organizationId = app('activeOrganization')->getKey();

        return view('pages.admin.roles', [
            'activeNav' => 'admin',
            'pageTitle' => 'Role Control',
            'pageDescription' => 'Organization-scoped roles and permissions for labs, analysts, and administrators.',
            'roles' => Role::query()
                ->where('organization_id', $organizationId)
                ->orWhereNull('organization_id')
                ->with('permissions')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
