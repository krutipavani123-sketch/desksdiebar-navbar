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
        $users = User::all();
        $teams = Team::all();
        return view("team.teamcreate", compact("users"));
    }
    public function list()
    {
        // $teams = Team::all();
        $teams = Team::with('users')->get();
        $users = User::all();
        return view("team.listteam", compact('teams', 'users'));
    }

    public function addteam(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "teamName" => "required",
            "users" => 'nullable|array'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $teams = Team::create([
                "teamName" => $request->teamName,
            ]);


            if ($request->has('users')) {
                $teams->users()->attach($request->users);
            }
            $teams->save();
            return redirect()->route('team.list')->with("success", "Team Created");
        }
    }



    public function edit(Request $request, $id)
    {
        $teams = Team::findOrFail($id);
        $users = User::all();
        return view("team.teamedit", compact("teams", 'users'));
    }

    public function update(Request $request, $id)
    {
        $teams = Team::findOrFail($id);
        $validator = Validator::make(request()->all(), [
            "teamName" => "required",
            "users" => 'nullable|array'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $teams->teamName = $request->teamName;


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
