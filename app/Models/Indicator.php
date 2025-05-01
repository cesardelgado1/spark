<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Indicator
 *
 * Represents an indicator associated with an objective in a strategic plan.
 * Indicators track measurable data (e.g., metrics, tasks) and can be assigned to users.
 *
 * Table: indicators
 */
class Indicator extends Model {
    use HasFactory;

    protected $table = 'indicators'; // The table associated with the model.
    protected $primaryKey = 'i_id'; // The primary key for the model.
    protected $fillable = ['i_num', 'i_text','i_type','i_value', 'i_locked', 'i_FY', 'o_id']; // The attributes that are mass assignable.

    /**
     * Get the objective that this indicator belongs to.
     *
     * @return BelongsTo
     */
    public function objective(): BelongsTo {
        return $this->belongsTo(Objective::class, 'o_id');
    }

    /**
     * Get the user assignments related to this indicator.
     *
     * @return HasMany
     */
    public function assignments(): HasMany {
        return $this->hasMany(AssignIndicators::class, 'ai_IndToFill');
    }
}
