<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'target_amount',
        'current_amount',
        'target_date',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPercentageAttribute(): float
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return round(min(($this->current_amount / $this->target_amount) * 100, 100), 1);
    }

    public function getIsCompleteAttribute(): bool
    {
        return $this->current_amount >= $this->target_amount;
    }
}