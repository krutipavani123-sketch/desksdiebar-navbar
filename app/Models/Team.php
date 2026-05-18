<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Team extends Model
{
    use HasRoles;
    protected $table = "teams";
    protected $fillable = ['teamName', 'leader_id', 'assigned_agent_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

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