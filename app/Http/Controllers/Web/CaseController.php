<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;
use Illuminate\View\View;

class CaseController extends Controller
{
    public function index(): View
    {
        return view('pages.cases.index', [
            'activeNav' => 'cases',
            'pageTitle' => 'Case Intelligence',
            'pageDescription' => 'Active investigations, priorities, severity, and analyst assignments.',
            'cases' => InvestigationCase::query()
                ->forActiveOrganization()
                ->withCount(['evidenceItems', 'forensicReports', 'members'])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(InvestigationCase $case): View
    {
        $case->load([
            'leadAnalyst',
            'members',
            'notes.user',
            'timelineEvents.actor',
            'evidenceItems.hashes',
            'forensicReports.sections',
            'labels',
        ])->loadCount(['evidenceItems', 'forensicReports', 'auditLogs']);

        return view('pages.cases.show', [
            'activeNav' => 'cases',
            'pageTitle' => $case->title,
            'pageDescription' => $case->summary ?: 'Case overview, evidence references, timeline, and reporting state.',
            'case' => $case,
        ]);
    }
}
