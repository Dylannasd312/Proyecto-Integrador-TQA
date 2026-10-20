<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCitaRequest;
use App\Http\Requests\UpdateCitaRequest;
use App\Models\Cita;

class CitaController extends Controller
{
    public function index()
    {
        return response()->json(
            Cita::with([
                'paciente',
                'medico',
                'especialidad',
                'consultorio'
            ])
            ->orderBy('fecha_cita')
            ->orderBy('hora_cita')
            ->get()
        );
    }

    public function store(StoreCitaRequest $request)
    {
        $datos = $request->validated();

        $datos['estado'] =
            $datos['estado'] ?? 'POR_PAGAR';

        $cita = Cita::create($datos);

        return response()->json([
            'message' => 'Cita creada correctamente',
            'data' => $cita->load([
                'paciente',
                'medico',
                'especialidad',
                'consultorio'
            ])
        ], 201);
    }

    public function show($id)
    {
        $cita = Cita::with([
            'paciente',
            'medico',
            'especialidad',
            'consultorio',
            'consulta',
            'pagoCita'
        ])->findOrFail($id);

        return response()->json($cita);
    }

    public function update(
        UpdateCitaRequest $request,
        $id
    ) {
        $cita = Cita::findOrFail($id);

        $cita->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Cita actualizada correctamente',
            'data' => $cita->fresh()->load([
                'paciente',
                'medico',
                'especialidad',
                'consultorio',
                'consulta',
                'pagoCita'
            ])
        ]);
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);

        $cita->update([
            'estado' => 'CANCELADA'
        ]);

        return response()->json([
            'message' =>
                'Cita cancelada correctamente'
        ]);
    }
}
