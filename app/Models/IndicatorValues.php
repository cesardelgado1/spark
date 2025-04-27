<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatorValues extends Model
{
    protected $table = 'indicator_values';
    protected $primaryKey = 'iv_id';

    protected $fillable = [
        'iv_u_id',
        'iv_ind_id',
        'iv_value',
    ];
    public function userFillingOutIndicator(): belongsTo {
        return $this->belongsTo(User::class, 'iv_u_id');
    }
    public function indicatorFilled(): belongsTo  {
        return $this->belongsTo(Indicator::class, 'iv_ind_id');
    }

}
