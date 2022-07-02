<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'type', 'patient'];

    public function type()
    {
        return $this->belongsTo(DetectionType::class, 'type');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient');
    }

    public function status()
    {
        return $this->morphMany(Status::class, 'status');
    }
}
