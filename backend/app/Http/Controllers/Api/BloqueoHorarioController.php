<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBloqueoHorarioRequest;
use App\Http\Requests\UpdateBloqueoHorarioRequest;
use App\Models\BloqueoHorario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BloqueoHorarioController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            BloqueoHorario::with([
                'medico'
            ])
            ->where('estado', true)
            ->orderBy('fecha_inicio')
            ->get()
        );
    }

    public function store(
        StoreBloqueoHorarioRequest $request
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $bloqueo = BloqueoHorario::create([
                'medico_id' =>
                    $request->medico_id,

                'fecha_inicio' =>
                    $request->fecha_inicio,

                'fecha_fin' =>
                    $request->fecha_fin,

                'motivo' =>
                    $request->motivo,

                'estado' => true
            ]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Bloqueo registrado correctamente',

                'data' =>
                    $bloqueo->load('medico')
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar bloqueo',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function show(
        $id
    ): JsonResponse {

        $bloqueo = BloqueoHorario::with([
            'medico'
        ])->findOrFail($id);

        return response()->json(
            $bloqueo
        );
    }

    public function update(
        UpdateBloqueoHorarioRequest $request,
        $id
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $bloqueo = BloqueoHorario::findOrFail($id);

            $bloqueo->update(
                $request->validated()
            );

            DB::commit();

            return response()->json([
                'message' =>
                    'Bloqueo actualizado correctamente',

                'data' =>
                    $bloqueo->fresh()->load(
                        'medico'
                    )
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al actualizar bloqueo',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function destroy(
        $id
    ): JsonResponse {

        $bloqueo = BloqueoHorario::findOrFail($id);

        $bloqueo->update([
            'estado' => false
        ]);

        return response()->json([
            'message' =>
                'Bloqueo desactivado correctamente'
        ]);
    }
}
