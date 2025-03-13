<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model {
    use HasFactory;

    protected $table = 'goals';
    protected $primaryKey = 'g_id';
    protected $fillable = ['g_num', 'g_text', 't_id'];

    public function topic(): BelongsTo {
        return $this->belongsTo(Topic::class, 't_id');
    }

    public function objectives(): HasMany {
        return $this->hasMany(Objective::class, 'g_id');
    }
}
