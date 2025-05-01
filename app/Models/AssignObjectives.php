<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AssignObjectives
 *
 * Represents the assignment of an objective to a user, storing who assigned it and who is responsible.
 *
 * Table: assign_objectives
 */
class AssignObjectives extends Model
{
    protected $table = 'assign_objectives'; // The table associated with the model.
    protected $primaryKey = 'ao_id'; // The primary key for the model.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ao_ObjToFill',      // Foreign key to the objective to be filled
        'ao_assigned_to',    // User ID of the person receiving the assignment
        'ao_assigned_by',    // User ID of the person making the assignment
    ];

    /**
     * Get the user who assigned the objective.
     *
     * @return BelongsTo
     */
    public function assignedBy(): belongsTo {
        return $this->belongsTo(User::class, 'ao_assigned_by');
    }

    /**
     * Get the user to whom the objective was assigned.
     *
     * @return BelongsTo
     */
    public function assignedTo(): belongsTo  {
        return $this->belongsTo(User::class, 'ao_assigned_to');
    }

    /**
     * Get the objective associated with the assignment.
     *
     * @return BelongsTo
     */
    public function objective(): BelongsTo {
        return $this->belongsTo(Objective::class, 'ao_ObjToFill');
    }

    /**
     * Alias for assignedTo relationship.
     *
     * @return BelongsTo
     */

    public function assignee(): BelongsTo {
        return $this->belongsTo(User::class, 'ao_assigned_to');
    }

}

