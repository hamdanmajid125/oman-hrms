<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Department, Team, Shift};
use Spatie\Permission\Models\Role;

use Hash;

class UserController extends Controller
{
    /**{{}}
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
        $shifts = Shift::all();
        return view('users.create',compact('data','dept','roles','users','shifts','team'));
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

    public function deleteRepeater(Request $request)
    {
        $user = User::find($request->id);
        $education = json_decode($user->getMeta($request->key),true);
        foreach ($education as $key => $subArray) {
            if ($subArray == $request->input('value')) {
                unset($education[$key]);
            }
        }
        $user->setMeta($request->key,json_encode($education));
        return response()->json(['status'=>true]);

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
        $dept = Department::all();
        $users = User::all();
        $roles = Role::all();
        $team = Team::all();
        $shifts = Shift::all();
        return view('users.create',compact('data','dept','roles','users','shifts','team'));
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
        $user = $request->has('id') ? User::find($request->id) : new User;
        $user->name = $request->name;
        $user->department_id = $request->department_id;
        $user->email = $request->email;
        $user->reporting_authority = $request->reporting_authority;
        $user->team_id = $request->team_id;
        $user->shift_id = $request->shift_id;
        $user->password = bcrypt('123456789');
        $user->save();

        foreach ($request->meta as $key => $value) {
           $user->setMeta($key,$value);
        }
        if ($request->has('education')) {
            $hasNull = false;
            $education_array = [];
            foreach ($request->input('education') as $education) {
                if (is_null($education['level']) || is_null($education['institute']) || is_null($education['grade'])) {
                    $hasNull = true;
                    break;
                }
            }
            if (!$hasNull) {
                $user->setMeta('education',json_encode($request->input('education')));
            }

        }
        if ($request->has('work_experience')) {
            $hasNull = false;
            $education_array = [];
            foreach ($request->input('work_experience') as $education) {
                if (is_null($education['company']) || is_null($education['position']) || is_null($education['year'])) {
                    $hasNull = true;
                    break;
                }
            }
            if (!$hasNull) {
                $user->setMeta('work_experience',json_encode($request->input('work_experience')));
            }

        }
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }
        return response()->json(['status' => true]);
    }
}
