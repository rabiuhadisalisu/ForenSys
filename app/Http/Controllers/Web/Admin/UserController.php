<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.users', [
            'activeNav' => 'admin',
            'pageTitle' => 'User Directory',
            'pageDescription' => 'Active users, organization memberships, and account verification state.',
            'users' => User::query()
                ->with(['organizations', 'activeOrganization'])
                ->latest()
                ->paginate(15),
        ]);
    }
}
