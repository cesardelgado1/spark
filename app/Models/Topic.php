<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model {
    use HasFactory;

    protected $table = 'topics';
    protected $primaryKey = 't_id';
    protected $fillable = ['t_num', 't_text', 'sp_id'];

    public function goals(): HasMany {
        return $this->hasMany(Goal::class, 't_id');
    }

    public function st_plan(): BelongsTo {
        return $this->belongsTo(StrategicPlan::class, 'sp_id');
    }
}
