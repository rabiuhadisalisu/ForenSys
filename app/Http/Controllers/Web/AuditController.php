<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function index(): View
    {
        return view('pages.audit.index', [
            'activeNav' => 'audit',
            'pageTitle' => 'Audit Explorer',
            'pageDescription' => 'Immutable-style accountability records across cases, evidence, tools, and administration.',
            'auditLogs' => AuditLog::query()
                ->forActiveOrganization()
                ->with(['user', 'investigationCase', 'evidenceItem'])
                ->latest('occurred_at')
                ->paginate(20),
        ]);
    }
}
