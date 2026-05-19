<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Team;
use App\Models\User;

class Ticket extends Model
{
    // use HasRoles;

    protected $table = 'tickets';
    protected $fillable = [
        'subject',
        'description',
        'priority',
        'category',
        'attachment',
        'status',
        'assigned_team_id',
        'assigned_agent_id',
        'customer_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'assigned_team_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
