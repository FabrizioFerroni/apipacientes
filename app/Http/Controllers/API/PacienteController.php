<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PacienteResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarPacienteRequest;
use App\Http\Requests\ActualizarPacienteRequest;
use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    public function index()
    {
        return PacienteResource::collection(Paciente::orderBy('id', 'DESC')->paginate(3));
    }

    public function store(GuardarPacienteRequest $request)
    {
        return (new PacienteResource(Paciente::create($request->all())))->additional(['mensaje' => 'Paciente guardado correctamente en la BD']);
    }

    public function show(Paciente $paciente)
    {
        return (new PacienteResource($paciente))->additional(['mensaje' => 'Se ha encontrado un registro con el id buscado']);
    }

    public function update(ActualizarPacienteRequest $request, Paciente $paciente)
    {
        $paciente->update($request->all());
        return (new PacienteResource($paciente))->additional(['mensaje' => 'Paciente actualizado correctamente en la BD'])->response()->setStatusCode(202);
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return (new PacienteResource($paciente))->additional(['mensaje' => 'Paciente eliminado correctamente en la BD']);
    }
}
