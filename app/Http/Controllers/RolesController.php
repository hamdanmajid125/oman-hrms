<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};

class RolesController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Roles';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        $permissions = Permission::all();
        return view('roles.create', compact('data','permissions'));
    }

    public function getRoles(Request $request)
    {
        $query = Role::where(function($query) use ($request) {
            $query->orWhere('name', 'like', "%" . $request->search['value'] . "%");
        })->with('permissions');
    
        $total = $query->count();
        $roles = $query->skip($request->start)->take($request->length)->get(['id', 'name']);
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $roles->map(function($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name')->map(function($item) {
                        return '<span class="badge bg-dark">' .ucwords($item) . '</span> ';
                    })->implode(''), 
                    'action' => '<a href="' . route('roles.edit', $role->id) . '" class="btn btn-sm btn-primary">Edit</a>'
                ];
            })
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $role = Role::create(['name' => $request->input('name')]);
        $role->permissions()->detach();

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission_name) {
                $role->givePermissionTo($permission_name);
            }
        }

        return redirect('roles')->with('success', 'Role added!');
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
        $data = Role::with('permissions')->find($id);

        $permissions = Permission::all();
        return view('roles.create', compact('data','permissions'));

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
        $this->validate($request, ['name' => 'required']);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        $role->permissions()->detach();

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission_name) {
                $permission = Permission::whereName($permission_name)->first();
                $role->givePermissionTo($permission);
            }
        }

        return redirect('roles')->with('success', 'Role updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
