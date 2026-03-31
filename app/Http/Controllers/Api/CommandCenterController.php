<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\EvidenceItem;
use App\Models\ForensicReport;
use App\Models\InvestigationCase;
use App\Models\ProcessingJob;
use App\Support\ToolCatalog;

class CommandCenterController extends Controller
{
    use RespondsWithApi;

    public function show()
    {
        return $this->successResponse([
            'stats' => [
                'cases' => InvestigationCase::query()->forActiveOrganization()->count(),
                'evidence' => EvidenceItem::query()->forActiveOrganization()->count(),
                'reports' => ForensicReport::query()->forActiveOrganization()->count(),
                'queued_jobs' => ProcessingJob::query()->forActiveOrganization()->whereIn('status', ['queued', 'processing'])->count(),
            ],
            'recent_cases' => InvestigationCase::query()->forActiveOrganization()->latest()->take(5)->get(),
            'recent_evidence' => EvidenceItem::query()->forActiveOrganization()->latest()->take(5)->get(),
            'recent_activity' => AuditLog::query()->forActiveOrganization()->latest('occurred_at')->take(8)->get(),
            'featured_tools' => ToolCatalog::all()->where('status', 'ready')->values(),
        ], 'Command center snapshot loaded.');
    }
}
