<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignObjectives extends Model
{
    protected $table = 'assign_objectives';
    protected $primaryKey = 'ao_id';

    protected $fillable = [
        'ao_ObjToFill',
        'ao_assigned_to',
        'ao_assigned_by',
    ];
    public function assignedBy(): belongsTo {
        return $this->belongsTo(User::class, 'ao_assigned_by');
    }
    public function assignedTo(): belongsTo  {
        return $this->belongsTo(User::class, 'ao_assigned_to');
    }
    public function objective(): BelongsTo {
        return $this->belongsTo(Objective::class, 'ao_ObjToFill');
    }
}

