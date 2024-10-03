<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use Carbon\Carbon;
class ShiftController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Shift';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Shift::all();
        return view('shifts.index',compact('data'));
    }

    public function getShifts(Request $request)
    {
        $query = Shift::where(function($query) use ($request) {
            $query->orWhere('name', 'like', "%" . $request->search['value'] . "%");
        });
    
        $total = $query->count();
        $shifts = $query->skip($request->start)->take($request->length)->get(['id', 'name','starting_time','ending_time','timing']);
    
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $shifts->map(function($shift) {
                return [
                    'id' => $shift->id,
                    'name' => $shift->name,
                    'starting_time' => $shift->starting_time,
                    'ending_time' => $shift->ending_time,
                    'timing' => $shift->timing,
                    'action' => '<a href="'.route('shifts.edit',$shift->id).'" class="btn btn-sm btn-primary">Edit</a>' 
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
        return view('shifts.create',compact('data'));
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
            'starting_time' => 'required',
            'ending_time' => 'required'
            ]);
            
        $shift = new Shift();
        $shift->fill($request->only(['name', 'starting_time', 'ending_time']));
            
        $start_time = Carbon::parse($request->input('starting_time'));
        $end_time = Carbon::parse($request->input('ending_time'));
        if ($end_time->lessThan($start_time)) {
            $end_time->addDay();
        }
        $shift->timing = $start_time->format('g:i A') . ' - ' . $end_time->format('g:i A');
        $shift->shift_hours = $start_time->diffInHours($end_time);
        $shift->save();
        return redirect()->route('shifts.index')->with('success', 'Shift Created Successfully');
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
        $data = Shift::find($id);
        return view('shifts.create',compact('data'));
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
            'starting_time' => 'required',
            'ending_time' => 'required'
        ]);
        $shift = Shift::find($id);
        $shift->fill($request->only(['name','starting_time','ending_time']));
        $start_time = Carbon::parse($request->input('starting_time'));
        $end_time = Carbon::parse($request->input('ending_time'));
        if($end_time->lessThan($start_time)){
            $end_time->addDay();
        }
        $shift->timing = $start_time->format('g:i A') . '-' . $end_time->format('g:i A');
        $shift->shift_hours = $start_time->diffInHours($end_time);
        $shift->save();
        return redirect()->route('shifts.index')->with('success', 'Shift Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        $shift->delete();
        return redirect()->route('shifts.index')->with('success','Shift Deleted Successfully');
    }
}
