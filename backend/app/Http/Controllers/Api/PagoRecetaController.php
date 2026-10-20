<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePagoRecetaRequest;
use App\Models\Comprobante;
use App\Models\Pago;
use App\Models\PagoReceta;
use App\Models\Receta;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PagoRecetaController extends Controller
{
    public function store(
        StorePagoRecetaRequest $request
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $receta = Receta::with([
                'consulta',
                'detalles.medicamento'
            ])->findOrFail(
                $request->receta_id
            );

            $existePago = PagoReceta::where(
                'receta_id',
                $receta->id
            )->exists();

            if ($existePago) {

    DB::rollBack();

    return response()->json([
        'message' =>
        'La receta ya fue pagada'
    ], 422);
}

            $total = 0;

            foreach (
                $receta->detalles
                as $detalle
            ) {

                $total +=
                    $detalle->cantidad *
                    $detalle->medicamento->precio_venta;
            }

            $pacienteId =
                $receta->consulta->paciente_id;

            $pago = Pago::create([
                'paciente_id' => $pacienteId,
                'metodo_pago_id' =>
                    $request->metodo_pago_id,
                'tipo_pago' => 'RECETA',
                'monto' => $total,
                'estado' => 'PAGADO',
                'observaciones' =>
                    $request->observaciones,
                'usuario_id' =>
                    $request->usuario_id,
                'fecha_pago' => now()
            ]);

            PagoReceta::create([
                'pago_id' => $pago->id,
                'receta_id' => $receta->id
            ]);

            $comprobante = Comprobante::create([
                'pago_id' => $pago->id,
                'numero_comprobante' =>
                    'COMP-' .
                    str_pad(
                        $pago->id,
                        8,
                        '0',
                        STR_PAD_LEFT
                    ),
                'fecha_emision' => now(),
                'total' => $total,
                'observaciones' =>
                    'Pago de receta médica'
            ]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Pago registrado correctamente',

                'pago' => $pago,

                'comprobante' => $comprobante,

                'total' => $total
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar pago',
                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }
}
