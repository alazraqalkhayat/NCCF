<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivitiesType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function activities(): HasMany
    {
        return $this->hasMany(Activities::class, 'type');
    }
}
