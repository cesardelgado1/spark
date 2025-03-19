<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = 'users'; // Laravel's default users table
    protected $primaryKey = 'id';

    protected $fillable = [
        'u_fname', 'u_lname', 'email', 'u_signup_date', 'u_type', 'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'u_signup_date' => 'datetime', // Ensures it's treated as a Carbon instance
    ];

    public function assignedTasks(): HasMany {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function createdTasks(): HasMany {
        return $this->hasMany(Task::class, 'assigned_by');
    }
}
