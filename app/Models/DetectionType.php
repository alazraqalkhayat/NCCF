<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectionType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function detections()
    {
        return $this->hasMany(Detection::class, 'type');
    }
}
