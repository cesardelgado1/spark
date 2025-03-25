<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StrategicPlan extends Model {
    use HasFactory;

    protected $table = 'strategic_plan';
    protected $primaryKey = 'sp_id';
    protected $fillable = ['sp_institution'];

    public function topics(): HasMany {
        return $this->hasMany(Topic::class, 'sp_id');
    }
}
