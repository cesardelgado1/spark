<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 *
 * Represents an authenticated user within the system.
 * Users can be assigned or receive objectives and indicators, and their actions are logged.
 *
 * Table: users
 */
class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = 'users'; // Laravel's default users table
    protected $primaryKey = 'id'; // The primary key for the model.

    protected $fillable = [
        'u_fname', 'u_lname', 'auth_type', 'email', 'u_signup_date', 'u_type', 'password'
    ]; //The attributes that are mass assignable

    protected $hidden = ['password', 'remember_token'];  // The attributes that should be hidden for serialization.

    protected $casts = [
        'u_signup_date' => 'datetime', // Ensures it's treated as a Carbon instance
    ]; // The attributes that should be cast to native types.

    /**
     * Get the objective assignments made by this user.
     *
     * @return HasMany
     */
    public function assignedObjectives(): HasMany {
        return $this->hasMany(AssignObjectives::class, 'ao_assigned_by');
    }

    /**
     * Get the objectives assigned to this user.
     *
     * @return HasMany
     */
    public function receivedObjectives(): HasMany {
        return $this->hasMany(AssignObjectives::class, 'ao_assigned_to');
    }

    /**
     * Get the indicator assignments made by this user.
     *
     * @return HasMany
     */
    public function assignedIndicator(): HasMany {
        return $this->hasMany(AssignIndicators::class, 'ai_assigned_by');
    }

    /**
     * Get the indicators assigned to this user.
     *
     * @return HasMany
     */
    public function recievedIndicators(): HasMany {
        return $this->hasMany(AssignIndicators::class, 'ai_assigned_to');
    }

    /**
     * Get the audit log entries associated with this user.
     *
     * @return HasMany
     */
    public function auditLogs(): hasMany {
        return $this->hasMany(AuditLogs::class, 'user_id');
    }
}
