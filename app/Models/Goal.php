<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Goal
 *
 * Represents a "Meta" (goal) within a strategic plan, which belongs to a topic
 * and has many associated objectives.
 *
 * Table: goals
 */
class Goal extends Model {
    use HasFactory;

    protected $table = 'goals'; // The table associated with the model.
    protected $primaryKey = 'g_id'; // The primary key for the model.
    protected $fillable = ['g_num', 'g_text', 't_id']; // The attributes that are mass assignable.

    /**
     * Get the topic that this goal belongs to.
     *
     * @return BelongsTo
     */
    public function topic(): BelongsTo {
        return $this->belongsTo(Topic::class, 't_id');
    }

    /**
     * Get the objectives that belong to this goal.
     *
     * @return HasMany
     */
    public function objectives(): HasMany {
        return $this->hasMany(Objective::class, 'g_id');
    }
}
