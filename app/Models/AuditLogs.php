<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditLogs extends Model {
    use HasFactory;

    protected $table = 'audit_logs';
    protected $primaryKey = 'al_id';
    protected $fillable = ['al_IPAddress', 'al_action', 'al_action_par', 'user_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
