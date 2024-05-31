<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'occupation_id',
        'work_regime_id',
        'work_model_id',
        'work_start_time',
        'work_end_time',
        'salary',
        'has_benefits',
        'extra_information',
        'min_age',
        'max_age',
        'education_id',
        'ethnicity_id',
        'has_experience',
        'has_disability',
        'has_travel',
        'has_language',
        'company',
        'responsible_person',
        'about',
        'postal_code',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }

    public function skylls(): BelongsToMany
    {
        return $this->belongsToMany(Skyll::class);
    }
}
