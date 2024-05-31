<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synonym extends Model
{
    use HasFactory;

    protected $table = 'synonyms';

    protected $fillable = [
        'code',
        'name'
    ];

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
}
