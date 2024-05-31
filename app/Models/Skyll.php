<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skyll extends Model
{
    use HasFactory;

    protected $fillable = [
        'occupation_id',
        'type',
        'description'
    ];

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class);
    }
}
