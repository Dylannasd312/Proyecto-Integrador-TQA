<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEspecialidadRequest;
use App\Http\Requests\UpdateEspecialidadRequest;
use App\Models\Especialidad;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EspecialidadController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Especialidad::where(
                'estado',
                true
            )
            ->orderBy('nombre')
            ->get()
        );
    }

    public function store(
        StoreEspecialidadRequest $request
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $especialidad = Especialidad::create([
                'nombre' =>
                    $request->nombre,

                'descripcion' =>
                    $request->descripcion,

                'precio_consulta' =>
                    $request->precio_consulta,

                'estado' => true
            ]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Especialidad registrada correctamente',

                'data' =>
                    $especialidad
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar especialidad',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function show(
        $id
    ): JsonResponse {

        $especialidad = Especialidad::findOrFail($id);

        return response()->json(
            $especialidad
        );
    }

    public function update(
        UpdateEspecialidadRequest $request,
        $id
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $especialidad =
                Especialidad::findOrFail($id);

            $especialidad->update(
                $request->validated()
            );

            DB::commit();

            return response()->json([
                'message' =>
                    'Especialidad actualizada correctamente',

                'data' =>
                    $especialidad->fresh()
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al actualizar especialidad',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function destroy(
        $id
    ): JsonResponse {

        $especialidad =
            Especialidad::findOrFail($id);

        $especialidad->update([
            'estado' => false
        ]);

        return response()->json([
            'message' =>
                'Especialidad desactivada correctamente'
        ]);
    }
}
