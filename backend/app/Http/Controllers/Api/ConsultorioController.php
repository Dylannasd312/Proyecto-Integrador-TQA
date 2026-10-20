<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsultorioRequest;
use App\Http\Requests\UpdateConsultorioRequest;
use App\Models\Consultorio;

class ConsultorioController extends Controller
{
    public function index()
    {
        return response()->json(
            Consultorio::where('estado', true)
                ->orderBy('id')
                ->get()
        );
    }

    public function show($id)
    {
        $consultorio = Consultorio::findOrFail($id);

        return response()->json($consultorio);
    }

    public function store(StoreConsultorioRequest $request)
    {
        $consultorio = Consultorio::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'estado' => true
        ]);

        return response()->json([
            'message' => 'Consultorio registrado correctamente',
            'data' => $consultorio
        ], 201);
    }

    public function update(
        UpdateConsultorioRequest $request,
        $id
    ) {
        $consultorio = Consultorio::findOrFail($id);

        $consultorio->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Consultorio actualizado correctamente',
            'data' => $consultorio
        ]);
    }

    public function destroy($id)
    {
        $consultorio = Consultorio::findOrFail($id);

        $consultorio->estado = false;
        $consultorio->save();

        return response()->json([
            'message' => 'Consultorio desactivado correctamente'
        ]);
    }
}
