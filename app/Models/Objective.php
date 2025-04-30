<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Objective extends Model {
    use HasFactory;

    protected $table = 'objectives';
    protected $primaryKey = 'o_id';
    protected $fillable = ['o_num', 'o_text', 'g_id'];

    public function goal(): BelongsTo {
        return $this->belongsTo(Goal::class, 'g_id');
    }

    public function indicators(): HasMany {
        return $this->hasMany(Indicator::class, 'o_id');
    }
    public function assignments(): HasMany {
        return $this->hasMany(AssignObjectives::class, 'ao_ObjToFill');
    }
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
