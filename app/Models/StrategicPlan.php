<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class StrategicPlan
 *
 * Represents a strategic plan entity that belongs to an institution and spans a range of years.
 * Each strategic plan consists of multiple topics ("asuntos").
 *
 * Table: strategic_plans
 */
class StrategicPlan extends Model {
    use HasFactory;

    protected $table = 'strategic_plans'; // The table associated with the model.
    protected $primaryKey = 'sp_id'; // The primary key for the model.
    protected $fillable = ['sp_institution', 'sp_years']; // The attributes that are mass assignable.

    /**
     * Get all topics (asuntos) associated with the strategic plan.
     *
     * @return HasMany
     */
    public function topics(): HasMany {
        return $this->hasMany(Topic::class, 'sp_id');
    }
}
