<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Carbon\Carbon;
class HolidayController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Holiday';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('holidays.index');
    }

    public function getHolidays(Request $request)
    {
        $query = Holiday::where(function($query) use ($request) {
            $query->orWhere('name', 'like', "%" . $request->search['value'] . "%");
        });
    
        $total = $query->count();
        $holidays = $query->skip($request->start)->take($request->length)->get(['id', 'name', 'date']);
    
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $holidays->map(function($holiday) {
                return [
                    'id' => $holiday->id,
                    'name' => $holiday->name,
                    'date' => Carbon::parse($holiday->date)->format('d-M-Y'),
                    'action' => '<a href="'.route('holidays.edit',$holiday->id).'" class="btn btn-sm btn-primary">Edit</a>' 
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
        return view('holidays.create',compact('data'));
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
            'date' => 'required'
        ]);
        $holiday = new Holiday();
        $holiday->fill($request->only(['name','date']));
        $holiday->save();
        return redirect()->route('holidays.index')->with('success','Holiday Created Successfully');
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
        $data = Holiday::find($id);
        return view('holidays.create',compact('data'));
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
            'date' => 'required'
        ]);
        $holiday = Holiday::find($id);
        $holiday->fill($request->only(['name','date']));
        $holiday->save();
        return redirect()->route('holidays.index')->with('success','Holiday Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();
        return redirect()->route('holidays.index')->with('success','Holiday Deleted Successfully');
    }
}
