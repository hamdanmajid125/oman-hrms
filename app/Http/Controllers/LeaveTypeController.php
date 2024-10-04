<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveTypes;
class LeaveTypeController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Leave Type';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leavetypes.index');
    }

    public function getLeaveTypes(Request $request)
    {
        $query = LeaveTypes::where(function($query) use ($request) {
            $query->orWhere('name', 'like', "%" . $request->search['value'] . "%");
        });
    
        $total = $query->count();
        $leavetypes = $query->skip($request->start)->take($request->length)->get(['id', 'name', 'days']);
    
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $leavetypes->map(function($leavetype) {
                return [
                    'id' => $leavetype->id,
                    'name' => $leavetype->name,
                    'days' => $leavetype->days,
                    'action' => '<a href="'.route('leavetypes.edit',$leavetype->id).'" class="btn btn-sm btn-primary">Edit</a>' 
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
        return view('leavetypes.create',compact('data'));
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
            'days'  => 'required'
        ]);

        $leavetype = new LeaveTypes();
        $leavetype->fill($request->only(['name','days']));
        $leavetype->save();
        return redirect()->route('leavetypes.index')->with('success','Leave Type Created Successfully');
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
        $data = LeaveTypes::find($id);
        return view('leavetypes.create',compact('data'));
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
            'days'  => 'required'
        ]);

        $leavetype = LeaveTypes::find($id);
        $leavetype->fill($request->only(['name','days']));
        $leavetype->save();
        return redirect()->route('leavetypes.index')->with('success','Leave Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leavetype = LeaveTypes::findOrFail($request->id);
        $leavetype->delete();
        return redirect()->route('leavetypes.index')->with('success','Leave Type Deleted Successfully');
    }
}
