<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvidenceItem;
use App\Models\LabScenarioAsset;
use Illuminate\View\View;

class StorageController extends Controller
{
    public function index(): View
    {
        $organizationId = app('activeOrganization')->getKey();

        return view('pages.admin.storage', [
            'activeNav' => 'admin',
            'pageTitle' => 'Storage Monitor',
            'pageDescription' => 'Evidence and lab asset storage footprint across the active organization.',
            'evidenceBytes' => EvidenceItem::query()->where('organization_id', $organizationId)->sum('size_bytes'),
            'labAssetBytes' => LabScenarioAsset::query()
                ->whereHas('labScenario', fn ($query) => $query->where('organization_id', $organizationId))
                ->sum('size_bytes'),
            'recentEvidence' => EvidenceItem::query()
                ->where('organization_id', $organizationId)
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }
}
