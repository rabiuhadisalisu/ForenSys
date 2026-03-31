<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Concerns\RespondsWithApi;
use App\Http\Controllers\Controller;
use App\Support\ToolCatalog;

class ToolController extends Controller
{
    use RespondsWithApi;

    public function index()
    {
        return $this->successResponse(ToolCatalog::all()->groupBy('family'), 'Tool catalog loaded.');
    }

    public function show(string $tool)
    {
        return $this->successResponse(ToolCatalog::findOrFail($tool), 'Tool detail loaded.');
    }
}
