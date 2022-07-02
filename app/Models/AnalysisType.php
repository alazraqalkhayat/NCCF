<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function analysises()
    {
        return $this->hasMany(Analysis::class, 'type');
    }
}
