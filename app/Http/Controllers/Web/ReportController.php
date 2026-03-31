<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ForensicReport;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('pages.reports.index', [
            'activeNav' => 'reports',
            'pageTitle' => 'Reporting Engine',
            'pageDescription' => 'Draft, review, and publish structured forensic reports from case evidence and findings.',
            'reports' => ForensicReport::query()
                ->forActiveOrganization()
                ->with(['investigationCase', 'creator'])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(ForensicReport $report): View
    {
        $report->load([
            'investigationCase',
            'creator',
            'approver',
            'sections',
            'versions.creator',
            'labels',
        ]);

        return view('pages.reports.show', [
            'activeNav' => 'reports',
            'pageTitle' => $report->title,
            'pageDescription' => 'Report sections, version snapshots, and review status for this investigation artifact.',
            'report' => $report,
        ]);
    }
}
