<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnalisisIARequest;
use App\Http\Requests\UpdateAnalisisIARequest;
use App\Models\AnalisisIA;

class AnalisisIAController extends Controller
{
    public function index()
    {
        return response()->json(
            AnalisisIA::with([
                'consulta',
                'paciente',
                'medico',
                'archivoClinico'
            ])->orderBy('id')->get()
        );
    }

    public function show($id)
    {
        $analisis = AnalisisIA::with([
            'consulta',
            'paciente',
            'medico',
            'archivoClinico'
        ])->findOrFail($id);

        return response()->json($analisis);
    }

    public function store(StoreAnalisisIARequest $request)
    {
        $analisis = AnalisisIA::create([
            'consulta_id' => $request->consulta_id,
            'paciente_id' => $request->paciente_id,
            'medico_id' => $request->medico_id,
            'archivo_clinico_id' => $request->archivo_clinico_id,
            'resultado' => $request->resultado,
            'confianza' => $request->confianza,
            'observaciones' => $request->observaciones,
            'fecha_analisis' => now()
        ]);

        return response()->json([
            'message' => 'Análisis IA registrado correctamente',
            'data' => $analisis
        ], 201);
    }

    public function update(
        UpdateAnalisisIARequest $request,
        $id
    ) {
        $analisis = AnalisisIA::findOrFail($id);

        $analisis->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Análisis IA actualizado correctamente',
            'data' => $analisis
        ]);
    }

    public function destroy($id)
    {
        $analisis = AnalisisIA::findOrFail($id);

        $analisis->delete();

        return response()->json([
            'message' => 'Análisis IA eliminado correctamente'
        ]);
    }
}
