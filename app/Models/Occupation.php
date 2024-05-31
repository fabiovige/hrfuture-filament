<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Occupation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function synonyms(): HasMany
    {
        return $this->hasMany(Synonym::class);
    }

    public function skylls(): HasMany
    {
        return $this->hasMany(Skyll::class);
    }

    public static function getOccupationCustom($name)
    {
        return DB::table('occupations as vo')
            ->join('synonyms as vs', 'vo.id', '=', 'vs.occupation_id')
            ->where('vo.name', 'like', "%{$name}%")
            ->orWhere('vs.name', 'like', "%{$name}%")
            ->select('vo.id', 'vo.name')
            ->distinct()
            ->pluck('vo.name', 'vo.id')
            ->toArray();
    }
}
