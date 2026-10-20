<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArchivoClinicoRequest;
use App\Http\Requests\UpdateArchivoClinicoRequest;
use App\Models\ArchivoClinico;

class ArchivoClinicoController extends Controller
{
    public function index()
    {
        return response()->json(
            ArchivoClinico::with([
                'consulta',
                'paciente',
                'tipoArchivo',
                'usuario'
            ])->orderBy('id')->get()
        );
    }

    public function show($id)
    {
        $archivo = ArchivoClinico::with([
            'consulta',
            'paciente',
            'tipoArchivo',
            'usuario'
        ])->findOrFail($id);

        return response()->json($archivo);
    }

    public function store(StoreArchivoClinicoRequest $request)
{
    $archivoSubido = $request->file('archivo');

    $nombreArchivo =
        time() . '_' .
        $archivoSubido->getClientOriginalName();

    $ruta = $archivoSubido->storeAs(
        'archivos_clinicos',
        $nombreArchivo,
        'public'
    );

    $archivo = ArchivoClinico::create([
        'consulta_id' => $request->consulta_id,
        'paciente_id' => $request->paciente_id,
        'tipo_archivo_id' => $request->tipo_archivo_id,

        'nombre_archivo' =>
            $archivoSubido->getClientOriginalName(),

        'ruta_archivo' => $ruta,

        'observaciones' => $request->observaciones,

        'fecha_subida' => now(),

        'usuario_id' => $request->usuario_id
    ]);

    return response()->json([
        'message' => 'Archivo clínico subido correctamente',
        'data' => $archivo
    ], 201);
}

    public function update(
        UpdateArchivoClinicoRequest $request,
        $id
    ) {
        $archivo = ArchivoClinico::findOrFail($id);

        $archivo->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Archivo clínico actualizado correctamente',
            'data' => $archivo
        ]);
    }

    public function destroy($id)
    {
        $archivo = ArchivoClinico::findOrFail($id);

        $archivo->delete();

        return response()->json([
            'message' => 'Archivo clínico eliminado correctamente'
        ]);
    }
}
