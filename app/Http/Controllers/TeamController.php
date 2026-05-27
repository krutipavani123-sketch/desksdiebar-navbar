<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\Team;
use  App\Models\User;
use  App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;
use  App\Models\Category;

class TeamController extends Controller
{

    use HasRoles;

    function clearDashboardCache()
    {
        Cache::forget('dashboard_stats');
        Cache::forget('admindashboard_stats');
        Cache::forget('leaderdashboard_stats');
        Cache::forget('agentdashboard_stats');
        Cache::forget('customerdashboard_tasks');
    }
    public function create()
    {
        $leaders = User::role('team_leader')->get();
        $users = User::role('support_agent')->get();
        $teamagents = User::role('support_agent')->get();
        $teams = Team::all();
        $categories = Category::all();
        return view("team.teamcreate", compact("users", "teams", "teamagents", "leaders", "categories"));
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
        } elseif ($user->hasRole('team_leader')) {
            $query = Team::with('users', 'leader', 'agent')->where('leader_id', $user->id);                   //only their team
        } else {
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

        $this->clearDashboardCache();
        return view("team.listteam", compact('teams', 'users'));
    }


    public function addteam(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "teamName" => "required|unique:teams,teamName",
            "leader_id" => 'nullable|exists:users,id',    //must exists
            "users" => 'nullable|array',
            "teamagents" => 'nullable|array',
            "category_id" => 'nullable|exists:categories,id',
            // "assigned_agent_id" => 'nullable|exists:users,id',

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
                "category_id" => $request->category_id,
                //"assigned_agent_id" => $request->assigned_agent_id,
                // $teams->leader_id = $request->leader_id; 

            ]);

            if ($request->filled('users')) {
                $teams->users()->attach($request->users); //pivot table(many to many)  attach new relation
            }
            if ($request->filled('teamagents')) {
                $teams->teamagents()->sync($request->teamagents);
            } else {
                $teams->teamagents()->sync([]);
            }
            // if ($request->filled('users')) {
            //     $teams->users()->attach($request->users);   //pivot table(many to many)  attach new relation
            // }
            // if ($request->has('users')) {
            //     $teams->users()->attach($request->users);
            // }
            // $teams->save();


            $this->clearDashboardCache();
            return redirect()->route('team.list')->with("success", "Team Created");
        }
    }



    public function edit(Request $request, $id)
    {
        $teams = Team::findOrFail($id);
        $users = User::role('support_agent')->get();
        $leaders = User::role('team_leader')->get();
        $teamagents = User::role('support_agent')->get();
        $selectedAgents = $teams->teamagents->pluck('id')->toArray();
        $categories = Category::all();
        return view("team.teamedit", compact("teams", 'users', 'teamagents', 'selectedAgents', 'leaders', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $teams = Team::findOrFail($id);
        $validator = Validator::make(request()->all(), [
            "teamName" => "required",
            "users" => 'nullable|array',
            "leader_id" => 'nullable|exists:users,id',
            "agents" => 'nullable|array',
            //    "category_id" => 'nullable|exists:categories,id',
            // "assigned_agent_id" => 'nullable|array',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $teams->teamName = $request->teamName;
            $teams->leader_id = $request->leader_id;
            $teams->category_id = $request->category_id;
            // $teams->assigned_agent_id = $request->assigned_agent_id;
            // $teams->save();
            if ($request->has('users')) {                                   //only show role has users
                $teams->users()->sync($request->users);
            } else {
                $teams->users()->sync([]);
            }
            if ($request->filled('teamagents')) {
                $teams->teamagents()->sync($request->teamagents);
            } else {
                $teams->teamagents()->sync([]);
            }
            $this->clearDashboardCache();
            $teams->save();
            return redirect()->route("team.list")->with("success", "Team Updated");
        }
    }

    public function delete($id)
    {
        $teams = Team::findOrFail($id);
        $teams->delete();
        $this->clearDashboardCache();
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