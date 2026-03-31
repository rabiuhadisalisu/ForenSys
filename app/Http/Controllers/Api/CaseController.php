<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;

class CaseController extends Controller
{
    use RespondsWithApi;

    public function index()
    {
        return $this->successResponse(
            InvestigationCase::query()
                ->forActiveOrganization()
                ->withCount(['evidenceItems', 'forensicReports', 'members'])
                ->latest()
                ->paginate(12),
            'Cases loaded successfully.',
        );
    }

    public function show(InvestigationCase $case)
    {
        $case->load(['leadAnalyst', 'members', 'notes.user', 'timelineEvents.actor', 'labels'])
            ->loadCount(['evidenceItems', 'forensicReports', 'auditLogs']);

        return $this->successResponse($case, 'Case detail loaded.');
    }
}
