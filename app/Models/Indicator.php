<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicator extends Model {
    use HasFactory;

    protected $table = 'indicators';
    protected $primaryKey = 'i_id';
    protected $fillable = ['i_num', 'i_text','i_type', 'i_doc_path','i_value', 'i_FY', 'o_id'];

    public function objective(): BelongsTo {
        return $this->belongsTo(Objective::class, 'o_id');
    }
    public function assignments(): HasMany {
        return $this->hasMany(AssignIndicators::class, 'ai_IndToFill');
    }
}
