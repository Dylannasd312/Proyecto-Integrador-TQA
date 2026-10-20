<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PacienteController extends Controller
{
    public function index()
    {
        return Paciente::with([
            'usuario',
            'sexo',
            'grupoSanguineo',
            'estadoCivil',
            'parentesco',
            'historiaClinica'
        ])
        ->where('estado', true)
        ->orderBy('id')
        ->get();
    }

    public function show($id)
    {
        $paciente = Paciente::with([
            'usuario',
            'sexo',
            'grupoSanguineo',
            'estadoCivil',
            'parentesco',
            'historiaClinica'
        ])->findOrFail($id);

        return response()->json($paciente);
    }

    public function store(StorePacienteRequest $request)
    {
        $paciente = DB::transaction(function () use ($request) {

            /*
             * Crear usuario del paciente
             */
            $usuario = User::create([
                'rol_id' => 9,
                'username' => $request->ci,
                'correo' => $request->correo,
                'password' => Hash::make($request->ci),
                'estado' => 'ACTIVO',
                'primer_acceso' => true
            ]);

            /*
             * Crear paciente
             */
            $paciente = Paciente::create([
                'usuario_id' => $usuario->id,
                'codigo_paciente' => $request->codigo_paciente,
                'ci' => $request->ci,
                'nombres' => $request->nombres,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'sexo_id' => $request->sexo_id,
                'grupo_sanguineo_id' => $request->grupo_sanguineo_id,
                'estado_civil_id' => $request->estado_civil_id,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => $request->direccion,
                'contacto_emergencia' => $request->contacto_emergencia,
                'telefono_emergencia' => $request->telefono_emergencia,
                'parentesco_id' => $request->parentesco_id,
                'estado' => true
            ]);

            /*
             * Crear historia clínica inicial
             */
            $paciente->historiaClinica()->create([
                'numero_historia' => 'HC-' . $paciente->codigo_paciente,
                'estado' => true
            ]);

            return $paciente;
        });

        return response()->json([
            'message' => 'Paciente registrado correctamente',
            'data' => $paciente->load([
                'usuario',
                'sexo',
                'grupoSanguineo',
                'estadoCivil',
                'parentesco',
                'historiaClinica'
            ])
        ], 201);
    }

    public function update(
        UpdatePacienteRequest $request,
        $id
    ) {
        $paciente = Paciente::findOrFail($id);

        $paciente->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Paciente actualizado correctamente',
            'data' => $paciente->load([
                'usuario',
                'sexo',
                'grupoSanguineo',
                'estadoCivil',
                'parentesco',
                'historiaClinica'
            ])
        ]);
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);

        $paciente->estado = false;
        $paciente->save();

        /*
         * También desactivamos el usuario
         * asociado al paciente.
         */
        $usuario = $paciente->usuario;

        if ($usuario) {
            $usuario->estado = 'INACTIVO';
            $usuario->save();
        }

        return response()->json([
            'message' => 'Paciente desactivado correctamente'
        ]);
    }
}
