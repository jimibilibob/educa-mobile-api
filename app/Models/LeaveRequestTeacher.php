<?php

namespace App\Models;

use App\Http\Requests\Traits\CamelCasing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequestTeacher extends Model
{
    use HasFactory, CamelCasing;

    protected $guarded = [];

    public $relationshipTypes = [
        'leaveRequest' => 'belongsTo'
    ];

    public $foreingKeyNames = [
        'leaveRequest' => 'leave_request_id',
    ];

    public function leaveRequest(): BelongsTo
    {
        return $this->belongsTo(LeaveRequest::class);
    }
}
