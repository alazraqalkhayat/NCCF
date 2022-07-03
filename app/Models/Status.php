<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function dose()
    {
        return $this->hasMany(Dose::class, 'status');
    }

    public function detection()
    {
        return $this->hasMany(Detection::class, 'status');
    }

    public function analysis()
    {
        return $this->hasMany(Analysis::class, 'status');
    }

    public function reson()
    {
        return $this->hasMany(Reason::class,'status');
    }
}
