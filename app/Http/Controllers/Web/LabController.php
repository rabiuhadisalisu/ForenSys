<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LabScenario;
use Illuminate\View\View;

class LabController extends Controller
{
    public function index(): View
    {
        return view('pages.labs.index', [
            'activeNav' => 'labs',
            'pageTitle' => 'Student Lab Mode',
            'pageDescription' => 'Guided scenarios, safe mock evidence, and instructor-controlled submissions.',
            'scenarios' => LabScenario::query()
                ->forActiveOrganization()
                ->withCount(['assets', 'assignments'])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(LabScenario $scenario): View
    {
        $scenario->load(['creator', 'assets', 'assignments.user', 'assignments.submissions']);

        return view('pages.labs.show', [
            'activeNav' => 'labs',
            'pageTitle' => $scenario->title,
            'pageDescription' => $scenario->overview ?: 'Scenario overview, assets, and assignment readiness.',
            'scenario' => $scenario,
        ]);
    }
}
