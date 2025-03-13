<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
