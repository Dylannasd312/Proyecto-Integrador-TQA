<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where(
            'username',
            $request->username
        )->first();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 401);
        }

        if (!Hash::check(
            $request->password,
            $user->password
        )) {
            return response()->json([
                'message' => 'Contraseña incorrecta'
            ], 401);
        }

        if ($user->estado !== 'ACTIVO') {
            return response()->json([
                'message' => 'Usuario inactivo'
            ], 403);
        }

        $token = $user->createToken(
            'auth_token'
        )->plainTextToken;

        $user->ultimo_login = now();
        $user->save();

        return response()->json([
            'token' => $token,
            'usuario' => $user
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(
            $request->user()
        );
    }

    public function logout(Request $request)
    {
        $request
            ->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'message' => 'Sesión cerrada'
        ]);
    }
}
