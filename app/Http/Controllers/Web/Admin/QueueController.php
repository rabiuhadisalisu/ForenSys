<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessingJob;
use Illuminate\View\View;

class QueueController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.queues', [
            'activeNav' => 'admin',
            'pageTitle' => 'Queue Monitor',
            'pageDescription' => 'Processing tasks, evidence extraction state, and long-running workspace jobs.',
            'jobs' => ProcessingJob::query()
                ->forActiveOrganization()
                ->latest()
                ->paginate(20),
        ]);
    }
}
