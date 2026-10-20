<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistorialCita;
use Illuminate\Http\JsonResponse;

class HistorialCitaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            HistorialCita::with([
                'cita.paciente',
                'cita.medico',
                'usuario'
            ])
            ->orderBy('created_at', 'desc')
            ->get()
        );
    }

    public function show(string $id): JsonResponse
    {
        $historial = HistorialCita::with([
            'cita.paciente',
            'cita.medico',
            'usuario'
        ])
        ->where('cita_id', $id)
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($historial);
    }

    public function store()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
