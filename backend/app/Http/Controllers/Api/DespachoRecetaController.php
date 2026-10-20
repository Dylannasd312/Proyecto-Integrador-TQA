<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDespachoRecetaRequest;
use App\Models\DespachoReceta;
use App\Models\PagoReceta;
use App\Models\Receta;
use App\Models\Lote;
use App\Models\MovimientoInventario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DespachoRecetaController extends Controller
{
    public function store(
        StoreDespachoRecetaRequest $request
    ): JsonResponse
    {
        DB::beginTransaction();

        try {

            $receta = Receta::with([
                'consulta',
                'detalles.medicamento'
            ])->findOrFail(
                $request->receta_id
            );

            $pagoReceta = PagoReceta::where(
                'receta_id',
                $receta->id
            )->first();

            if (!$pagoReceta) {

                return response()->json([
                    'message' =>
                        'La receta aún no fue pagada'
                ], 422);
            }

            $despachoExistente =
                DespachoReceta::where(
                    'receta_id',
                    $receta->id
                )->first();

            if ($despachoExistente) {

                return response()->json([
                    'message' =>
                        'La receta ya fue despachada'
                ], 422);
            }

            foreach ($receta->detalles as $detalle) {

    $cantidadPendiente = $detalle->cantidad;

    $lotes = Lote::where(
        'medicamento_id',
        $detalle->medicamento_id
    )
    ->where(
        'stock_actual',
        '>',
        0
    )
    ->where(
        'estado',
        'ACTIVO'
    )
    ->orderBy(
        'fecha_vencimiento',
        'asc'
    )
    ->get();

    $stockDisponible = $lotes->sum('stock_actual');

    if ($stockDisponible < $detalle->cantidad) {

        throw new \Exception(
            'Stock insuficiente para el medicamento: '
            . $detalle->medicamento->nombre
        );
    }

    foreach ($lotes as $lote) {

        if ($cantidadPendiente <= 0) {
            break;
        }

        $cantidadSalida = min(
            $cantidadPendiente,
            $lote->stock_actual
        );

        $lote->decrement(
            'stock_actual',
            $cantidadSalida
        );
        $lote->refresh();

if ($lote->stock_actual <= 0) {
    $lote->update([
        'estado' => 'AGOTADO'
    ]);
}

        MovimientoInventario::create([
            'medicamento_id' =>
                $detalle->medicamento_id,

            'lote_id' =>
                $lote->id,

            'tipo_movimiento_id' =>
                2,

            'cantidad' =>
                $cantidadSalida,

            'referencia' =>
                'Despacho receta #' . $receta->id,

            'observacion' =>
                'Salida por receta médica',

            'usuario_id' =>
                $request->usuario_id,

            'created_at' =>
                now()
        ]);

        $cantidadPendiente -= $cantidadSalida;
    }
}

            $despacho = DespachoReceta::create([
                'receta_id' =>
                    $receta->id,

                'usuario_id' =>
                    $request->usuario_id,

                'fecha_despacho' =>
                    now(),

                'observaciones' =>
                    $request->observaciones
            ]);

            $receta->update([
                'estado' =>
                    'DESPACHADA'
            ]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Receta despachada correctamente',

                'despacho' =>
                    $despacho,

                'receta' =>
                    $receta->fresh()
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al despachar receta',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }
}
