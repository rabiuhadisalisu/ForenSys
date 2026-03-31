<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Support\ToolCatalog;
use Illuminate\View\View;

class ToolController extends Controller
{
    public function index(): View
    {
        return view('pages.tools.index', [
            'activeNav' => 'tools',
            'pageTitle' => 'Forensic Utilities Suite',
            'pageDescription' => 'Safe forensic utilities, evidence review helpers, and defensible workflow tools.',
            'tools' => ToolCatalog::all()->groupBy('family'),
        ]);
    }

    public function show(string $tool): View
    {
        return view('pages.tools.show', [
            'activeNav' => 'tools',
            'pageTitle' => 'Tool Workspace',
            'pageDescription' => 'Execution panels, guardrails, and future AJAX-driven results for a selected tool.',
            'tool' => ToolCatalog::findOrFail($tool),
        ]);
    }
}
