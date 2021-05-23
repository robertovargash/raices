<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:gestion_permisos', ['only' => ['index','store','create','edit','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permisos = Permission::all();
        $title = "Permisos";
        return view('permissions.index',compact('permisos','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Permisos";
        return view('permissions.create',compact('title'));
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
                'name' => ['required','unique:permissions,name'],
            ],[
                'name.required' => 'Campo obligatorio',
                'name.unique' => 'El permiso ya existe'
            ]);
        // $permiso = Permission::create($request->all());
        Permission::create($request->all());

        return redirect()->route('permissions.index')
                        ->with('success','Permiso creado');
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
        $permiso = Permission::find($id);
        $title = "Permisos";

        return view('permissions.edit',compact('permiso','title'));
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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $permiso = Permission::find($id);
        $permiso->name = $request->input('name');
        $permiso->save();

        return redirect()->route('permissions.index')
                        ->with('success','Permiso actualizado');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table("permissions")->where('id',$request->id)->delete();
        return redirect()->route('permissions.index')
                        ->with('success','Permiso eliminado');
    }
}
