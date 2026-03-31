<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;

class CaseEvidenceController extends Controller
{
    use RespondsWithApi;

    public function index(InvestigationCase $case)
    {
        return $this->successResponse(
            $case->evidenceItems()->with(['hashes', 'labels'])->latest()->get(),
            'Case evidence loaded.',
        );
    }
}
