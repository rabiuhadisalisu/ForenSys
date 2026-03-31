<?php

namespace App\Models;

use App\Models\Concerns\OrganizationScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

class Label extends Model
{
    use OrganizationScoped;

    public function investigationCases(): MorphedByMany
    {
        return $this->morphedByMany(InvestigationCase::class, 'labelable');
    }

    public function evidenceItems(): MorphedByMany
    {
        return $this->morphedByMany(EvidenceItem::class, 'labelable');
    }

    public function forensicReports(): MorphedByMany
    {
        return $this->morphedByMany(ForensicReport::class, 'labelable');
    }
}
