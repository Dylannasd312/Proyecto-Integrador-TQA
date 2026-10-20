<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoriaClinica;
use Illuminate\Http\Request;

class HistoriaClinicaController extends Controller
{
    public function index()
    {
        $historias = HistoriaClinica::with([
            'paciente.usuario',
            'paciente.sexo',
            'paciente.grupoSanguineo',
            'paciente.estadoCivil',
            'paciente.parentesco'
        ])
        ->where('estado', true)
        ->orderBy('id')
        ->get();

        return response()->json($historias);
    }

    public function show($id)
    {
        $historia = HistoriaClinica::with([
            'paciente.usuario',
            'paciente.sexo',
            'paciente.grupoSanguineo',
            'paciente.estadoCivil',
            'paciente.parentesco'
        ])->findOrFail($id);

        return response()->json($historia);
    }

    public function update(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        $validated = $request->validate([
            'antecedentes_personales' =>
                'nullable|string',

            'antecedentes_familiares' =>
                'nullable|string',

            'alergias' =>
                'nullable|string',

            'observaciones' =>
                'nullable|string'
        ]);

        $historia->update($validated);

        return response()->json([
            'message' => 'Historia clínica actualizada correctamente',
            'data' => $historia->load([
                'paciente.usuario',
                'paciente.sexo',
                'paciente.grupoSanguineo',
                'paciente.estadoCivil',
                'paciente.parentesco'
            ])
        ]);
    }
}
