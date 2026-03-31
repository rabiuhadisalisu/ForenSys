<?php

namespace App\Services\Reports;

use App\Models\ForensicReport;

class ReportBuilderService
{
    /**
     * Build a minimal structured snapshot for a report draft.
     *
     * @return array<string, mixed>
     */
    public function draftSnapshot(ForensicReport $report): array
    {
        return [
            'report_id' => $report->getKey(),
            'title' => $report->title,
            'status' => $report->status,
            'section_count' => $report->sections()->count(),
        ];
    }
}
