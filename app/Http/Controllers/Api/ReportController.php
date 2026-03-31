<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\ForensicReport;

class ReportController extends Controller
{
    use RespondsWithApi;

    public function index()
    {
        return $this->successResponse(
            ForensicReport::query()->forActiveOrganization()->with(['investigationCase', 'creator'])->latest()->paginate(12),
            'Reports loaded.',
        );
    }

    public function show(ForensicReport $report)
    {
        $report->load(['investigationCase', 'creator', 'approver', 'sections', 'versions.creator', 'labels']);

        return $this->successResponse($report, 'Report detail loaded.');
    }
}
