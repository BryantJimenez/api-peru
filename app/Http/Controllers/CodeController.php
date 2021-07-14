<?php

namespace App\Http\Controllers;

use App\User;
use App\Code;
use App\Query;
use App\Http\Requests\CodeStoreRequest;
use App\Http\Requests\CodeUpdateRequest;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CodeStoreRequest $request, User $user) {
        if ($user->state=="0") {
            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'warning', 'title' => 'Usuario desactivado', 'msg' => 'El usuario esta desactivado, no puede crearle un código nuevo.']);
        }
        
        // Agregar codigo de API al usuario
        $code=generate_code();
        $data=array('name' => request('name'), 'code' => $code, 'limit' => request('limit'), 'user_id' => $user->id);
        $code=Code::create($data);

        if ($code) {
            Query::create(['type' => '1', 'code_id' => $code->id]);
            Query::create(['type' => '2', 'code_id' => $code->id]);

            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El código ha sido registrado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CodeUpdateRequest $request, Code $code) {
        $data=array('name' => request('name'), 'limit' => request('limit'));
        $code->fill($data)->save();

        if ($code) {
            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El código ha sido editado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        $code->delete();
        if ($code) {
            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El código ha sido eliminado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, Code $code) {
        $code->fill(['state' => "0"])->save();
        if ($code) {
            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El código ha sido desactivado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, Code $code) {
        $code->fill(['state' => "1"])->save();
        if ($code) {
            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El código ha sido activado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
