<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class Topic
 *
 * Represents a topic ("Asunto") within a strategic plan.
 * Each topic belongs to a specific strategic plan and can have many goals.
 *
 * Table: topics
 */
class Topic extends Model {
    use HasFactory;

    protected $table = 'topics'; // The table associated with the model.
    protected $primaryKey = 't_id'; // The primary key for the model.
    protected $fillable = ['t_num', 't_text', 'sp_id'];  // The attributes that are mass assignable.

    /**
     * Get the goals (metas) associated with this topic.
     *
     * @return HasMany
     */
    public function goals(): HasMany {
        return $this->hasMany(Goal::class, 't_id');
    }

    /**
     * Get the strategic plan this topic belongs to.
     *
     * @return BelongsTo
     */
    public function strategicplan(): BelongsTo {
        return $this->belongsTo(StrategicPlan::class, 'sp_id');
    }
}
