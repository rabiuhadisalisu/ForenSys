<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditController extends Controller
{
    use RespondsWithApi;

    public function index()
    {
        return $this->successResponse(
            AuditLog::query()->forActiveOrganization()->with(['user', 'investigationCase', 'evidenceItem'])->latest('occurred_at')->paginate(20),
            'Audit logs loaded.',
        );
    }
}
