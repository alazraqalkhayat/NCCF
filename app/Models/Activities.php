<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'path'];

    public function type(){
        return $this->belongsTo(ActivitiesType::class,'type');
    }
}
