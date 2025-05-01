<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class RoleRequest
 *
 * Represents a request from a user to gain a specific role within a department.
 * These requests can be reviewed and approved or rejected by administrators.
 *
 * Table: role_requests
 */
class RoleRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',        // ID of the user making the request
        'department',     // Department the user belongs to or is requesting access to
        'requested_role', // Role the user is requesting (e.g., planner, contributor)
        'status',         // Status of the request (e.g., pending, approved, rejected)
    ];

    /**
     * Get the user who made the role request.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
