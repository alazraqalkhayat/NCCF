<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'type', 'patient','status'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(AnalysisType::class, 'type');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function reason(): MorphMany
    {
        return $this->morphMany(Reason::class, 'reason');
    }
}
