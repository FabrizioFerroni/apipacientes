<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use Str;
use Illuminate\Support\Str;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'identificador'=> $this->id,
            'nombre' => Str::of($this->nombres)->title(),
            'apellido' =>Str::of($this->apellidos)->title(),
            'edad' => $this->edad,
            'sexo' => $this->sexo,
            'dni' => $this->dni,
            'tipo_de_sangre' => $this->tipo_sangre,
            'telefono' => $this->telefono,
            'correo' => Str::of($this->correo)->lower(),
            'direccion' => Str::of($this->direccion)->title(),
            'fecha_creacion' => $this->created_at->format('d-m-y H:i:s'),
            'fecha_actualizacion' => $this->updated_at->format('d-m-y H:i:s'),
        ];
    }
    public function with($request){
        return [
            'respuesta' => true
        ];
    }
}
