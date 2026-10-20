<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return User::with('rol')
            ->orderBy('id')
            ->get();
    }

    public function show($id)
    {
        return User::with('rol')
            ->findOrFail($id);
    }

    public function store(StoreUsuarioRequest $request)
    {
        $usuario = User::create([

            'rol_id' => $request->rol_id,

            'username' => $request->username,

            'correo' => $request->correo,

            'password' => Hash::make(
                $request->password
            ),

            'estado' => $request->estado,

            'primer_acceso' => true
        ]);

        return response()->json([
            'message' => 'Usuario creado',
            'data' => $usuario
        ], 201);
    }

    public function update(
        UpdateUsuarioRequest $request,
        $id
    )
    {
        $usuario = User::findOrFail($id);

        $usuario->update([

            'rol_id' => $request->rol_id,

            'username' => $request->username,

            'correo' => $request->correo,

            'estado' => $request->estado
        ]);

        return response()->json([
            'message' => 'Usuario actualizado',
            'data' => $usuario
        ]);
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->estado = 'INACTIVO';

        $usuario->save();

        return response()->json([
            'message' => 'Usuario desactivado'
        ]);
    }
}
