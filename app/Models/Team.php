<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "teams";
    protected $fillable = ['teamName', 'leader_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function agents()
    {
        return $this->belongsToMany(User::class);
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