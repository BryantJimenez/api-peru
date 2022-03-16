<?php

namespace App\Http\Controllers;

use App\User;
use App\Code;
use App\Query;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailRegister;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users=User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles=Role::all()->pluck('name');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request) {
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'company' => request('company'), 'doi' => request('doi'), 'address' => request('address'), 'email' => request('email'), 'password' => Hash::make(request('password')));
        $user=User::create($data);

        if ($user) {
            $user->assignRole(request('type'));

            // Agregar codigo de API al usuario
            $code=generate_code();
            $data=array('name' => 'Primero', 'code' => $code, 'limit' => 1000, 'user_id' => $user->id);
            $code=Code::create($data);

            if ($code) {
                Query::create(['type' => '1', 'code_id' => $code->id]);
                Query::create(['type' => '2', 'code_id' => $code->id]);
            }

            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
            }

            SendEmailRegister::dispatch($user->slug);
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El usuario ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('usuarios.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        $codes=$user->codes()->with(['macs'])->get();
        return view('admin.users.show', compact('user', 'codes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        if (Auth::user()->id==$user->id) {
            return redirect()->route('profile.edit');
        }
        $roles=Role::all()->pluck('name');
        return view('admin.users.edit', compact("user", "roles"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user) {
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'company' => request('company'), 'doi' => request('doi'), 'address' => request('address'), 'state' => request('state'));
        $user->fill($data)->save();        

        if ($user) {
            $user->syncRoles([request('type')]);

            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
            }

            return redirect()->route('usuarios.edit', ['user' => $user->slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El usuario ha sido editado exitosamente.']);
        } else {
            return redirect()->route('usuarios.edit', ['user' => $user->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        if ($user) {
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El usuario ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('usuarios.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, User $user) {
        $user->fill(['state' => "0"])->save();
        if ($user) {
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El usuario ha sido desactivado exitosamente.']);
        } else {
            return redirect()->route('usuarios.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, User $user) {
        $user->fill(['state' => "1"])->save();
        if ($user) {
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El usuario ha sido activado exitosamente.']);
        } else {
            return redirect()->route('usuarios.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
