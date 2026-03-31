<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\EvidenceItem;
use App\Models\ForensicReport;
use App\Models\InvestigationCase;
use App\Models\ProcessingJob;
use App\Support\ToolCatalog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommandCenterController extends Controller
{
    public function index(Request $request): View
    {
        $organization = $request->attributes->get('activeOrganization');

        $stats = [
            [
                'label' => 'Active Cases',
                'value' => InvestigationCase::query()->forActiveOrganization()->whereIn('status', ['open', 'in_review', 'escalated'])->count(),
                'accent' => 'cyan',
                'caption' => 'Live investigations in the workspace',
            ],
            [
                'label' => 'Evidence Locked',
                'value' => EvidenceItem::query()->forActiveOrganization()->count(),
                'accent' => 'emerald',
                'caption' => 'Tracked evidence items with reference IDs',
            ],
            [
                'label' => 'Queued Jobs',
                'value' => ProcessingJob::query()->forActiveOrganization()->whereIn('status', ['queued', 'processing'])->count(),
                'accent' => 'amber',
                'caption' => 'Background extraction, hashing, and indexing',
            ],
            [
                'label' => 'Reports Drafted',
                'value' => ForensicReport::query()->forActiveOrganization()->count(),
                'accent' => 'blue',
                'caption' => 'Case reports and review artifacts',
            ],
        ];

        return view('pages.command-center.index', [
            'activeNav' => 'command-center',
            'pageTitle' => 'ForenDesk Command Center',
            'pageDescription' => 'A forensic operations workspace for cases, evidence, reporting, and controlled learning flows.',
            'activeOrganization' => $organization,
            'stats' => $stats,
            'recentCases' => InvestigationCase::query()
                ->forActiveOrganization()
                ->withCount(['evidenceItems', 'forensicReports'])
                ->latest()
                ->take(6)
                ->get(),
            'recentEvidence' => EvidenceItem::query()
                ->forActiveOrganization()
                ->latest()
                ->take(6)
                ->get(),
            'activityFeed' => AuditLog::query()
                ->forActiveOrganization()
                ->latest('occurred_at')
                ->take(8)
                ->get(),
            'processingJobs' => ProcessingJob::query()
                ->forActiveOrganization()
                ->latest()
                ->take(6)
                ->get(),
            'featuredTools' => ToolCatalog::all()->where('status', 'ready')->take(6),
        ]);
    }
}
