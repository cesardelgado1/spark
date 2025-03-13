<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model {
    use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'u_id';
    protected $fillable = ['u_fname', 'u_lname', 'u_email', 'u_signup_date', 'u_type'];

    public function assignedTasks(): HasMany {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function createdTasks(): HasMany {
        return $this->hasMany(Task::class, 'assigned_by');
    }
}
