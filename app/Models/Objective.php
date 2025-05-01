<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Objective
 *
 * Represents an objective ("Objetivo") that belongs to a specific goal in a strategic plan.
 * An objective can have multiple indicators and user assignments.
 *
 * Table: objectives
 */
class Objective extends Model {
    use HasFactory;

    protected $table = 'objectives'; // The table associated with the model.
    protected $primaryKey = 'o_id'; // The primary key for the model.
    protected $fillable = ['o_num', 'o_text', 'g_id']; // The attributes that are mass assignable.

    /**
     * Get the goal this objective belongs to.
     *
     * @return BelongsTo
     */
    public function goal(): BelongsTo {
        return $this->belongsTo(Goal::class, 'g_id');
    }

    /**
     * Get all indicators associated with this objective.
     *
     * @return HasMany
     */
    public function indicators(): HasMany {
        return $this->hasMany(Indicator::class, 'o_id');
    }

    /**
     * Get all objective assignment records (e.g. assigned users).
     *
     * @return HasMany
     */
    public function assignments(): HasMany {
        return $this->hasMany(AssignObjectives::class, 'ao_ObjToFill');
    }

    /**
     * Get the users assigned to this objective (through AssignObjectives).
     *
     * @return HasManyThrough
     */
    public function assignedUsers(): HasManyThrough {
        return $this->hasManyThrough(
            User::class,             // Final model we want
            AssignObjectives::class, // Intermediate model
            'ao_ObjToFill',          // Foreign key on AssignObjectives
            'id',                    // Foreign key on User
            'o_id',                  // Local key on Objective
            'ao_assigned_to'         // Local key on AssignObjectives
        );
    }
}
