<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistroRequest;
use App\Http\Requests\AccesoRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Hash, Bcrypt;

class AutenticarController extends Controller
{
    public function registro(RegistroRequest $request)
    {
        $user = new User();
        $user->name = e($request->name);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        // $user->password = hash::make($request->password);
        // $user->password = $request->password;
        $user->save();

        return response()->json([
            'respusta' => true,
            'mensaje' => 'Usuario registrado correctamente'
        ], 200);
    }

    public function acceso(AccesoRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'mensaje' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Usuario logueado con éxito',
            'token' => $token
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