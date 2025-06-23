<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Email;
use App\Models\Media;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $teams = Team::with('users')->where('user_id',auth()->id())->get();

        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();

        $media = Media::where('user_id', auth()->id())->get();

        return view('pages.team', compact('users','teams','emails','media'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'team_description' => 'nullable|string',
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        $team = new Team();
        $team->team_name = $request->team_name;
        $team->team_description = $request->team_description;
        $team->user_id = auth()->id();
        $team->save();

        // $team->users()->attach(auth()->id());

        $team->users()->attach($request->users);

        return redirect()->route('team.index')->with('success', 'Team created and users assigned successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team) {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        // dd($request->all());
        try {
            $request->validate([
                'team_name' => 'required|string|max:255',
                'team_description' => 'nullable|string',
                'users' => 'required|array',
                'users.*' => 'exists:users,id'
            ]);

            $team->update([
                'team_name' => $request->team_name,
                'team_description' => $request->team_description,
            ]);

            $team->users()->sync($request->users);

            return redirect()->back()->with('success', 'Team updated successfully!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team deleted successfully.'
        ]);
    }
}
