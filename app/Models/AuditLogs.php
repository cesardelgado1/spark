<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class AuditLogs
 *
 * Represents a log entry that records user actions in the system.
 * Logs include the user, action performed, parameters associated with the action,
 * and the user's IP address.
 *
 * Table: audit_logs
 */
class AuditLogs extends Model {
    use HasFactory;

    protected $table = 'audit_logs'; // The table associated with the model.
    protected $primaryKey = 'al_id'; // The primary key for the model.
    protected $fillable = ['al_IPAddress', 'al_action', 'al_action_par', 'user_id']; // The attributes that are mass assignable.


    /**
     * Relationship: the user who performed the action.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Static helper to log a new audit event.
     *
     * @param string $action Description of the action (e.g. "Deleted Indicator", "Logged In")
     * @param mixed $param Additional context or parameter related to the action (can be string or any serializable data)
     *
     * @return void
     */
    public static function log(string $action, $param)
    {
        if (!auth()->check()) return; // Skip if no authenticated user

        self::create([
            'user_id'        => auth()->id(),
            'al_action'      => $action,
            'al_action_par' => $param,
            'al_IPAddress'   => request()->ip(),
        ]);
    }

}
