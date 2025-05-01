<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class IndicatorValues
 *
 * Represents the value a user has entered for a specific indicator.
 * Each row ties a user to an indicator with their corresponding input.
 *
 * Table: indicator_values
 */
class IndicatorValues extends Model
{
    protected $table = 'indicator_values'; // The table associated with the model.
    protected $primaryKey = 'iv_id'; // The primary key for the model.

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'iv_u_id',     // ID of the user who submitted the value
        'iv_ind_id',   // ID of the indicator this value belongs to
        'iv_value',    // The value provided by the user
    ];

    /**
     * Get the user who filled out the indicator.
     *
     * @return BelongsTo
     */
    public function userFillingOutIndicator(): belongsTo {
        return $this->belongsTo(User::class, 'iv_u_id');
    }

    /**
     * Get the indicator that was filled out.
     *
     * @return BelongsTo
     */
    public function indicatorFilled(): belongsTo  {
        return $this->belongsTo(Indicator::class, 'iv_ind_id');
    }

}
