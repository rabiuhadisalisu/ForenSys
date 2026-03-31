<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Models\LabScenario;

class LabController extends Controller
{
    use RespondsWithApi;

    public function index()
    {
        return $this->successResponse(
            LabScenario::query()->forActiveOrganization()->withCount(['assets', 'assignments'])->latest()->paginate(12),
            'Lab scenarios loaded.',
        );
    }

    public function show(LabScenario $scenario)
    {
        $scenario->load(['creator', 'assets', 'assignments.user', 'assignments.submissions']);

        return $this->successResponse($scenario, 'Lab scenario detail loaded.');
    }
}
