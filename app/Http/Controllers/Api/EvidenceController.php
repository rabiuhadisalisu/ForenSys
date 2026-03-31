<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\EvidenceItem;

class EvidenceController extends Controller
{
    use RespondsWithApi;

    public function show(EvidenceItem $evidence)
    {
        $evidence->load([
            'investigationCase',
            'uploader',
            'hashes.computedBy',
            'metadataRecords',
            'notes.user',
            'custodyLogs.recorder',
            'labels',
        ]);

        return $this->successResponse($evidence, 'Evidence detail loaded.');
    }
}
