<?php

use App\Http\Controllers\API\PacienteController;
use App\Http\Controllers\AutenticarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('pacientes', [PacienteController::class, 'index']);
// Route::post('pacientes', [PacienteController::class, 'store']);
// Route::get('paciente/{paciente}', [PacienteController::class, 'show']);
// Route::put('paciente/{paciente}/editar', [PacienteController::class, 'update']);
// Route::delete('paciente/{paciente}/eliminar', [PacienteController::class, 'destroy']);

route::post('registro', [AutenticarController::class, 'registro']);
route::post('iniciarsesion', [AutenticarController::class, 'acceso']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::apiResource('pacientes', PacienteController::class);
    Route::post('cerrarsesion', [AutenticarController::class, 'cerrarsesion']);
});

