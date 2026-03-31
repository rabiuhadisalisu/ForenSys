<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\EvidenceItem;

class EvidenceHashController extends Controller
{
    use RespondsWithApi;

    public function index(EvidenceItem $evidence)
    {
        return $this->successResponse(
            $evidence->hashes()->with('computedBy')->orderByDesc('is_primary')->get(),
            'Evidence hashes loaded.',
        );
    }
}
