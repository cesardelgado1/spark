<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Indicator extends Model {
    use HasFactory;

    protected $table = 'indicators';
    protected $primaryKey = 'i_id';
    protected $fillable = ['i_num', 'i_prompt', 'i_resp_num', 'i_resp_text', 'i_resp_file', 'i_FY', 'o_id'];

    public function objective(): BelongsTo {
        return $this->belongsTo(Objective::class, 'o_id');
    }
}
