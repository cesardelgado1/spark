<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignIndicators extends Model
{
    protected $table = 'assign_indicators';
    protected $primaryKey = 'ai_id';

    protected $fillable = [
        'ai_IndToFill',
        'ai_assigned_by',
        'ai_assigned_to',
        'ai_assigned_on',
        'ai_completed_on',
    ];
    public function assignedBy(): belongsTo {
        return $this->belongsTo(User::class, 'ai_assigned_by');
    }
    public function assignedTo(): belongsTo  {
        return $this->belongsTo(User::class, 'ai_assigned_to');
    }
    public function indicator(): belongsTo  {
        return $this->belongsTo(Indicator::class, 'ai_IndToFill');
    }
}

