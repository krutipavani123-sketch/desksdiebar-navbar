<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\Team;
use  App\Models\User;
use  App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class TeamController extends Controller
{

    use HasRoles;
    public function create()
    {
        $users = User::role('support_agent')->get();
        $teams = Team::all();
        return view("team.teamcreate", compact("users", "teams"));
    }
    public function list(Request $request)
    {
        // $teamId = DB::table('team_user')
        //     ->where('user_id', auth()->id())
        //     ->value('team_id');



        // if superadmin show all team and if leader login show only their team
        $user = auth()->user();


        if ($user && $user->hasAnyRole(['superadmin', 'admin'])) {

            $query = Team::query()->with('users', 'leader', 'agent');
        } 
        elseif ($user->hasRole('team_leader')) {
            $query = Team::with('users', 'leader', 'agent')->where('leader_id', $user->id);                   //only their team
        } 
        else {
            $query = Team::with('users', 'leader')
                ->whereHas('users', function ($q) use ($user) { //only they assigned 
                    $q->where('users.id', $user->id);
                });
        }

        //else {
        //     $query = Team::with('users', 'leader')
        //         ->where('leader_id', auth()->id());           // only show own team
        // }

        if ($request->filled('search')) {
            $query->where('teamName', 'like', '%' . request('search') . '%');
        }

        $teams = $query->get();
        //  $teams = Team::with('users', 'leader')->get();
        $users = User::role('support_agent')->get();
        // $agents = $query->get();
        return view("team.listteam", compact('teams', 'users'));
    }


    public function addteam(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "teamName" => "required",
            "leader_id" => 'nullable|exists:users,id',    //must exists
            "users" => 'nullable|array',
            "assigned_agent_id" => 'nullable|exists:users,id',
        ]);


        // if ($request->users) {
        // User::whereIn('id', $request->users)->update(['team_id' => $request->team_id]);
        // }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $teams = Team::create([
                "teamName" => $request->teamName,
                "leader_id" => $request->leader_id,
                "assigned_agent_id" => $request->assigned_agent_id,
                // $teams->leader_id = $request->leader_id; 

            ]);

            if ($request->filled('users')) {
                $teams->users()->attach($request->users);   //pivot table(many to many)  attach new relation
            }
            // if ($request->has('users')) {
            //     $teams->users()->attach($request->users);
            // }
            // $teams->save();
            return redirect()->route('team.list')->with("success", "Team Created");
        }
    }



    public function edit(Request $request, $id)
    {
        $teams = Team::findOrFail($id);
        $users = User::role('support_agent')->get();
        return view("team.teamedit", compact("teams", 'users'));
    }

    public function update(Request $request, $id)
    {
        $teams = Team::findOrFail($id);
        $validator = Validator::make(request()->all(), [
            "teamName" => "required",
            "users" => 'nullable|array',
            "leader_id" => 'nullable|exists:users,id',
            // "assigned_agent_id" => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $teams->teamName = $request->teamName;
            $teams->leader_id = $request->leader_id;
            $teams->assigned_agent_id = $request->assigned_agent_id;
            // $teams->save();
            if ($request->has('users')) {                                   //only show role has users
                $teams->users()->sync($request->users);
            } else {
                $teams->users()->sync([]);
            }

            $teams->save();
            return redirect()->route("team.list")->with("success", "Team Updated");
        }
    }

    public function delete($id)
    {
        $teams = Team::findOrFail($id);
        $teams->delete();
        return redirect()->route("team.list")->with("success", "Deleted");
    }
}










    //  public function list()
    //     {

    //         $teamId = DB::table('team_user')
    //             ->where('user_id', auth()->id())
    //             ->value('team_id');

    //         $teams = Team::with('users', 'leader')
    //             ->where('id', $teamId)
    //             ->get();


    //         $teams = Team::with('users', 'leader')->get();
    //         // $teams = Team::all();
    //         if (request()->filled('search')) {
    //             $search = request()->search;


    //             $teams->where('teamName', 'like', "%{$search}%");
    //         }

    //         //  $teams = Team::with('users', 'leader')->get();
    //         $users = User::role('support_agent')->get();
    //         return view("team.listteam", compact('teams', 'users'));
    //     }