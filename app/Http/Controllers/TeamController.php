<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Team, User, Department};
class TeamController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Teams';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teams.index');
    }

    public function getTeams(Request $request)
    {
        $query = Team::where(function($query) use ($request) {
            $query->orWhere('name', 'like', "%" . $request->search['value'] . "%");
        });
    
        $total = $query->count();
        $teams = $query->skip($request->start)->take($request->length)->get(['id','name','leader_id']);
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $teams->map(function($team) {
                $leader = User::where('id',$team->leader_id)->pluck('name');
                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'lead' => $leader,
                    'action' => '<a href="'.route('teams.edit',$team->id).'" class="btn btn-sm btn-primary">Edit</a>' 
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        $users = User::all();
        $dept = Department::all();
        return view('teams.create',compact('data','users','dept'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'leader_id' => 'required',
            'department_id' => 'required'
        ]);

        $team = new Team();
        $team->fill($request->only(['name','leader_id','department_id']));
        $team->save();
        return redirect()->route('teams.index')->with('success','Team Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Team::find($id);
        $users = User::all();
        $dept = Department::all();
        return view('teams.create',compact('data','users','dept'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'leader_id' => 'required',
            'department_id' => 'required'
        ]);

        $team = Team::find($id);
        $team->fill($request->only(['name','leader_id','department_id']));
        $team->save();
        return redirect()->route('teams.index')->with('success','Team Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $team = Team::findOrFail($request->id);
        $team->delete();
        return redirect()->route('teams.index')->with('success','Team Deleted Successfully');
    }
}
