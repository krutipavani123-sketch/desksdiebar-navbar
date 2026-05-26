<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'ticket_id',
        'user_id',
        'action',
        'old_value',
        'new_value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
