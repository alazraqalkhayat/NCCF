<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychologicalAid extends Model
{
    use HasFactory;

    protected $fillable = ['problem'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient');
    }
}
