<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reson extends Model
{
    use HasFactory;

    protected $fillable = ['reson'];

    public function reson(): MorphTo
    {
        return $this->morphTo();
    }
}
