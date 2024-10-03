<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Department, Team};
use Spatie\Permission\Models\Role;

use Hash;

class UserController extends Controller
{
    /**{{  }}
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
       
        return view('users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        $dept = Department::all();
        $users = User::all();
        $roles = Role::all();
        $team = Team::all();
        return view('users.create',compact('data','dept','roles','users','team'));
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
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $user->setMeta('employee_id',$request->input('emp_id'));
        $user->setMeta('date_of_join',$request->input('doj'));
        $user->setMeta('phone',$request->input('phone'));
        $user->setMeta('gender',$request->input('gender'));
        return redirect()->route('users.index')->with('success','Employee Created Successfully');
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
        $data = User::findOrFail($id);
        return view('users.create',compact('data'));
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
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $user->setMeta('employee_id',$request->input('emp_id'));
        $user->setMeta('date_of_join',$request->input('doj'));
        $user->setMeta('phone',$request->input('phone'));
        $user->setMeta('gender',$request->input('gender'));
        return redirect()->route('users.index')->with('success','Employee Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return redirect()->route('users.index')->with('success','Employee Deleted Successfully');
    }

    public function saveEmployeeForm(Request $request)
    {
        dd($request->all());
    }
}
