<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class AssignIndicators
 *
 * Represents the assignment of an indicator to a specific user, along with metadata
 * about who assigned it and when it was completed.
 *
 * Table: assign_indicators
 */
class AssignIndicators extends Model
{
    protected $table = 'assign_indicators'; // The table associated with the model.
    protected $primaryKey = 'ai_id'; // The primary key for the model.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ai_IndToFill',       // Foreign key to indicator to be filled
        'ai_assigned_by',     // User ID of the person assigning the indicator
        'ai_assigned_to',     // User ID of the person receiving the assignment
        'ai_assigned_on',     // Timestamp of when the assignment was made
        'ai_completed_on',    // Timestamp of when the assignment was completed
    ];

    /**
     * Get the user who assigned the indicator.
     *
     * @return BelongsTo
     */
    public function assignedBy(): belongsTo {
        return $this->belongsTo(User::class, 'ai_assigned_by');
    }

    /**
     * Get the user to whom the indicator was assigned.
     *
     * @return BelongsTo
     */
    public function assignedTo(): belongsTo  {
        return $this->belongsTo(User::class, 'ai_assigned_to');
    }

    /**
     * Get the indicator associated with this assignment.
     *
     * @return BelongsTo
     */
    public function indicator(): belongsTo  {
        return $this->belongsTo(Indicator::class, 'ai_IndToFill');
    }
}

