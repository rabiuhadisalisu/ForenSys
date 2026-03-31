<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\InvestigationCase;

class CaseTimelineController extends Controller
{
    use RespondsWithApi;

    public function index(InvestigationCase $case)
    {
        return $this->successResponse(
            $case->timelineEvents()->with('actor')->latest('event_at')->get(),
            'Case timeline loaded.',
        );
    }
}
