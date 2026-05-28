<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Team extends Model
{

    public $timestamps = true;
    use HasRoles;
    protected $table = "teams";
    protected $fillable = ['teamName', 'leader_id', 'assigned_agent_id', 'category_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    // public function agents()
    // {
    //     return $this->belongsToMany(User::class, 'team_user')
    //         ->role('support_agent');
    // }

    public function agents()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }
    //for ticket assign
    public function teamagents()
    {
        return $this->belongsToMany(User::class, 'team_agent', 'team_id', 'user_id');
        // table connected , table name , another table primary key(foreign key)
    }
    // public function agents()
    // {
    //     return $this->belongsToMany(User::class, 'team_user')
    //         ->whereHas('roles', function ($q) {
    //             $q->where('name', 'support_agent');
    //         });
    // }


    // public function agentss()
    // {
    //     return $this->belongsToMany(User::class, 'team_agent');
    // }
    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id'); // foreign key in teams table 
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_team_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'team_user');
    // }
}
// $team = Team::withCount('tickets')
    // ->orderBy('tickets_count')
    // ->orderBy('id')
    // ->first();


//     public function reassignTicket(Request $request)
// {
//     $request->validate([
//         'ticket_ids' => 'required|array',
//         'team_id' => 'required|exists:teams,id',
//     ]);

//     Ticket::whereIn('id', $request->ticket_ids)
//         ->update([
//             'assigned_team_id' => $request->team_id
//         ]);

//     return redirect()->back()->with('success', 'Ticket Reassigned Successfully');
// }


// Ticket::whereIn('id', $request->ticket_ids)
//     ->update([
//         'assigned_team_id' => $request->team_id
//     ]);