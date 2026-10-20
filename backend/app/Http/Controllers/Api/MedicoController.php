<?php

namespace App\Http\Controllers\Api;

use App\Models\Medico;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicoRequest;
use App\Http\Requests\UpdateMedicoRequest;

class MedicoController extends Controller
{
    public function index()
    {
        return Medico::with([
            'usuario',
            'especialidades'
        ])
        ->orderBy('id')
        ->get();
    }

    public function show($id)
    {
        return Medico::with([
            'usuario',
            'especialidades'
        ])
        ->findOrFail($id);
    }

    public function store(StoreMedicoRequest $request)
    {
        $medico = Medico::create([

            'usuario_id' => $request->usuario_id,
            'ci' => $request->ci,
            'matricula_profesional' => $request->matricula_profesional,
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado' => true
        ]);

        $medico->especialidades()->sync(
            $request->especialidades
        );

        return response()->json([
            'message' => 'Médico registrado',
            'data' => $medico->load('especialidades')
        ], 201);
    }

    public function update(
        UpdateMedicoRequest $request,
        $id
    )
    {
        $medico = Medico::findOrFail($id);

        $medico->update([

            'usuario_id' => $request->usuario_id,
            'ci' => $request->ci,
            'matricula_profesional' => $request->matricula_profesional,
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_ingreso' => $request->fecha_ingreso
        ]);

        $medico->especialidades()->sync(
            $request->especialidades
        );

        return response()->json([
            'message' => 'Médico actualizado',
            'data' => $medico->load('especialidades')
        ]);
    }

    public function destroy($id)
    {
        $medico = Medico::findOrFail($id);

        $medico->estado = false;

        $medico->save();

        return response()->json([
            'message' => 'Médico desactivado'
        ]);
    }
}
