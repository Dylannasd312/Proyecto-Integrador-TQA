<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecetaRequest;
use App\Models\Consulta;
use App\Models\Receta;
use App\Models\RecetaDetalle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Receta::with([
                'consulta',
                'detalles.medicamento',
                'despacho'
            ])
            ->orderByDesc('id')
            ->get()
        );
    }

    public function store(
        StoreRecetaRequest $request
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $consulta = Consulta::findOrFail(
                $request->consulta_id
            );

            if (
                $consulta->estado !==
                'EN_CURSO'
            ) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'Solo se puede emitir receta para consultas en curso'
                ], 422);
            }

            $recetaExistente = Receta::where(
                'consulta_id',
                $consulta->id
            )->exists();

            if ($recetaExistente) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'La consulta ya tiene una receta registrada'
                ], 422);
            }

            $receta = Receta::create([
                'consulta_id' =>
                    $consulta->id,

                'fecha_receta' =>
                    now(),

                'observaciones' =>
                    $request->observaciones,

                'estado' =>
                    'EMITIDA'
            ]);

            foreach (
                $request->detalles
                as $detalle
            ) {

                RecetaDetalle::create([
                    'receta_id' =>
                        $receta->id,

                    'medicamento_id' =>
                        $detalle['medicamento_id'],

                    'cantidad' =>
                        $detalle['cantidad'],

                    'dosis' =>
                        $detalle['dosis'],

                    'frecuencia' =>
                        $detalle['frecuencia'],

                    'duracion' =>
                        $detalle['duracion'],

                    'indicaciones' =>
                        $detalle['indicaciones']
                        ?? null
                ]);
            }

            DB::commit();

            return response()->json([
                'message' =>
                    'Receta registrada correctamente',

                'data' =>
                    Receta::with([
                        'consulta',
                        'detalles.medicamento',
                        'despacho'
                    ])->find(
                        $receta->id
                    )
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar receta',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function show(
        Receta $receta
    ): JsonResponse {

        return response()->json(
            $receta->load([
                'consulta',
                'detalles.medicamento',
                'despacho'
            ])
        );
    }

    public function update(): JsonResponse
    {
        return response()->json([
            'message' =>
                'Pendiente'
        ]);
    }

    public function destroy(
        Receta $receta
    ): JsonResponse {

        if (
            $receta->estado ===
            'ANULADA'
        ) {

            return response()->json([
                'message' =>
                    'La receta ya se encuentra anulada'
            ], 422);
        }

        if (
            $receta->estado ===
            'DESPACHADA'
        ) {

            return response()->json([
                'message' =>
                    'No se puede anular una receta ya despachada'
            ], 422);
        }

        $receta->update([
            'estado' => 'ANULADA'
        ]);

        return response()->json([
            'message' =>
                'Receta anulada correctamente',

            'data' =>
                $receta->fresh()
        ]);
    }
}
