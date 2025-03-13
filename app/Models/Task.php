<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model {
    use HasFactory;

    protected $table = 'tasks';
    protected $primaryKey = 't_id';
    protected $fillable = ['assigned_by', 'assigned_to', 'assigned_on', 'completed_on'];

    public function assigner(): BelongsTo {
        return $this->belongsTo(Usuario::class, 'assigned_by');
    }

    public function assignee(): BelongsTo {
        return $this->belongsTo(Usuario::class, 'assigned_to');
    }
}
