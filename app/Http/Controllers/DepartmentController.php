<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
class DepartmentController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Department';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments.index');
    }

    public function getDepartments(Request $request)
    {
        $query = Department::where(function($query) use ($request) {
            $query->orWhere('name', 'like', "%" . $request->search['value'] . "%");
        });
    
        $total = $query->count();
        $departments = $query->skip($request->start)->take($request->length)->get(['id', 'name']);
    
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $departments->map(function($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                    'action' => '<a href="'.route('departments.edit',$department->id).'" class="btn btn-sm btn-primary">Edit</a>' 
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
        return view('departments.create',compact('data'));
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
            'desc' => 'required'
        ]);

        $department = new Department();
        $department->fill($request->only(['name','desc']));
        $department->save();
        return redirect()->route('departments.index')->with('success','Department Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Department::find($id);
        return view('departments.create',compact('data'));
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
            'desc' => 'required'
        ]);

        $department = Department::find($id);
        $department->fill($request->only(['name','desc']));
        $department->save();
        return redirect()->route('departments.index')->with('success','Department Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $department = Department::findOrFail($request->id);
        $department->delete();
        return redirect()->route('departments.index')->with('success','Department Deleted Successfully');
    }
}
