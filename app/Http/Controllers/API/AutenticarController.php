<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroRequest;
use App\Http\Requests\AccesoRequest;
use App\Http\Resources\AutenticarResource;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Bcrypt;
use Illuminate\Support\Facades\Hash;

class AutenticarController extends Controller
{
    public function registro(RegistroRequest $request)
    {
        $user = new User();
        $user->name = e($request->name);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->attach($request->roles);
        $rol = $user->roles()->get();

        return response()->json([
            'respusta' => true,
            'mensaje' => 'Usuario registrado correctamente',
            'usuario' => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ],
            "roles" => $rol
        ], 200);
    }

    public function acceso(AccesoRequest $request)
    {
        $user = User::with('roles')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'mensaje' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        $rol = $user->roles()->get();

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Usuario logueado con éxito',
            'token' => $token,
            'usuario' => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "roles" => $rol
            ]
        ], 200);
    }

    public function cerrarsesion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Cerro sesión correctamente'
        ]);
    }
}
