<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\EvidenceItem;
use Illuminate\View\View;

class EvidenceController extends Controller
{
    public function show(EvidenceItem $evidence): View
    {
        $evidence->load([
            'investigationCase',
            'uploader',
            'hashes.computedBy',
            'metadataRecords',
            'notes.user',
            'custodyLogs.recorder',
            'labels',
        ])->loadCount(['toolRuns', 'auditLogs']);

        return view('pages.evidence.show', [
            'activeNav' => 'evidence',
            'pageTitle' => $evidence->display_name,
            'pageDescription' => 'Evidence metadata, integrity history, notes, and custody activity.',
            'evidence' => $evidence,
        ]);
    }
}
