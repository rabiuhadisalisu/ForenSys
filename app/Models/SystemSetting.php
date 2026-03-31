<?php

namespace App\Models;

use App\Models\Concerns\OrganizationScoped;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use OrganizationScoped;

    protected $casts = [
        'value_json' => 'array',
        'is_public' => 'boolean',
    ];
}
