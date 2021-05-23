<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);+
        $this->middleware('permission:gestion_usuarios', ['only' => ['index','store','create','edit','update','show','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        $title = "Usuarios";
        return view('users.index', compact('usuarios','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Registrando usuario";
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('title','roles'));
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
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required','confirmed'],
        ],[
            'email.unique' => 'El correo ya existe',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $name = $request->name;
    	$email = $request->email;
		$profession = $request->profession;
        $password = Hash::make($request->password);

        $user = User::create([
            "name" => $name,
            "profession" => $profession,
            "email" => $email,
            "password" => $password
        ]);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')->with('success','Usuario insertado');
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
    public function edit(User $user)
    {
        $title = "Editando usuario";
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            // 'password' => ['required','confirmed'],
        ],[
            'email.unique' => 'El correo ya existe',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $name = $request->name;
    	$email = $request->email;
		$profession = $request->profession;
        // $password = Hash::make($request->password);

        $user->update([
            "name" => $name,
            "profession" => $profession,
            "email" => $email,
            // "password" => $password
        ]);

        DB::table('model_has_roles')->where('model_id',$user->id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','Usuario modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id=$request->input('id');
        $user = User::find($user_id);
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success','Usuario eliminado');
    }
}
