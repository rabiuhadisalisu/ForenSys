<?php

namespace App\Models;

use App\Models\Concerns\OrganizationScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkspaceNotification extends Model
{
    use OrganizationScoped;

    protected $table = 'workspace_notifications';

    protected $casts = [
        'data_json' => 'array',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function investigationCase(): BelongsTo
    {
        return $this->belongsTo(InvestigationCase::class, 'case_id');
    }
}
