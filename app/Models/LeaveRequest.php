<?php

namespace App\Models;

use App\Http\Requests\Traits\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveRequest extends Model
{
    use HasFactory, CamelCasing;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public $relationshipTypes = [
        'type' => 'belongsTo',
        'leaveRequestTeachers' => 'hasMany'
    ];

    public $foreingKeyNames = [
        'type' => 'type_id'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(LeaveRequestType::class);
    }

    public function leaveRequestTeachers(): HasMany
    {
        return $this->hasMany(LeaveRequestTeacher::class);
    }
}
