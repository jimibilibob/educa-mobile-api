<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveRequestType extends Model
{
    use HasFactory;

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

}
