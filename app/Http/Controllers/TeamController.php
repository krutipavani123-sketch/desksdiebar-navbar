<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\Team;
use  App\Models\User;

class TeamController extends Controller
{
    public function create()
    {
        $users = User::role('support_agent')->get();
        $teams = Team::all();
        return view("team.teamcreate", compact("users", "teams"));
    }
    public function list()
    {
        $teams = Team::with('users', 'leader')->get();
        // $teams = Team::all();
        if (request()->filled('search')) {
            $search = request()->search;


            $teams->where('teamName', 'like', "%{$search}%");
        }

        //  $teams = Team::with('users', 'leader')->get();
        $users = User::role('support_agent')->get();
        return view("team.listteam", compact('teams', 'users'));
    }


    public function addteam(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "teamName" => "required",
            "leader_id" => 'nullable|exists:users,id',
            "users" => 'nullable|array'
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
                // $teams->leader_id = $request->leader_id; 

            ]);

            if ($request->filled('users')) {
                $teams->users()->attach($request->users);
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
            "leader_id" => 'nullable|exists:users,id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $teams->teamName = $request->teamName;
            $teams->leader_id = $request->leader_id;
            // $teams->save();
            if ($request->has('users')) {
                $teams->users()->sync($request->users);
            } else {
                $teams->users()->sync([]);
            }

            $teams->save();
            return redirect()->route("team.list")->with("success", "Team Updated");
        }
    }
}
