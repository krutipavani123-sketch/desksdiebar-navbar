<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Team;
use App\Models\User;

class Ticket extends Model
{

    public $timestamps = true;
    // use HasRoles;

    protected $table = 'tickets';
    protected $fillable = [
        'subject',
        'description',
        'priority',
        'category_id',
        'attachment',
        'status',
        'assigned_team_id',
        'assigned_agent_id',
        'customer_id',
        'sla_deadline',
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

    public function internalnote()
    {
        return $this->hasMany(InternalNote::class, '');
    }
    public function Note()
    {
        return $this->hasOne(InternalNote::class);
    }
    // for mail when ticket close 
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }


    public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}   
}
