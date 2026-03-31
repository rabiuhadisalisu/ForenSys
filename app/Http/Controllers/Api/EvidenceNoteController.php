<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\EvidenceItem;

class EvidenceNoteController extends Controller
{
    use RespondsWithApi;

    public function index(EvidenceItem $evidence)
    {
        return $this->successResponse(
            $evidence->notes()->with('user')->latest()->get(),
            'Evidence notes loaded.',
        );
    }
}
