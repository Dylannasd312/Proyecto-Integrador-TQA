<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompraRequest;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Lote;
use App\Models\Medicamento;
use App\Models\MovimientoInventario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Compra::with([
                'proveedor',
                'detalles.medicamento'
            ])->get()
        );
    }

    public function store(
        StoreCompraRequest $request
    ): JsonResponse
    {
        DB::beginTransaction();

        try {

            $total = 0;

            foreach ($request->detalles as $detalle) {

                $total += (
                    $detalle['cantidad']
                    *
                    $detalle['precio_unitario']
                );
            }

            $compra = Compra::create([
    'proveedor_id' =>
        $request->proveedor_id,

    'usuario_id' =>
        $request->usuario_id,

    'numero_factura' =>
        $request->numero_factura,

    'fecha_compra' =>
        $request->fecha_compra,

    'monto_total' =>
        $total,

    'estado' =>
        'REGISTRADA',

    'observaciones' =>
        $request->observaciones
]);

            foreach ($request->detalles as $detalle) {

                $subtotal =
                    $detalle['cantidad']
                    *
                    $detalle['precio_unitario'];

                CompraDetalle::create([
    'compra_id' =>
        $compra->id,

    'medicamento_id' =>
        $detalle['medicamento_id'],

    'cantidad' =>
        $detalle['cantidad'],

    'precio_unitario' =>
        $detalle['precio_unitario'],

    'subtotal' =>
        $subtotal,

    'numero_lote' =>
        $detalle['numero_lote'],

    'fecha_vencimiento' =>
        $detalle['fecha_vencimiento']
]);

               $lote = Lote::create([
    'compra_id' =>
        $compra->id,

    'medicamento_id' =>
        $detalle['medicamento_id'],

    'numero_lote' =>
        $detalle['numero_lote'],

    'fecha_vencimiento' =>
        $detalle['fecha_vencimiento'],

    'cantidad_inicial' =>
        $detalle['cantidad'],

    'stock_actual' =>
        $detalle['cantidad'],

    'fecha_ingreso' =>
        now(),

    'estado' =>
        'ACTIVO'
]);

                Medicamento::where(
                    'id',
                    $detalle['medicamento_id']
                )->update([
                    'precio_compra_promedio' =>
                        $detalle['precio_unitario']
                ]);

                MovimientoInventario::create([
                    'medicamento_id' =>
                        $detalle['medicamento_id'],

                    'lote_id' =>
                        $lote->id,

                    'tipo_movimiento_id' =>
                        1,

                    'cantidad' =>
                        $detalle['cantidad'],

                    'referencia' =>
                        'Compra #' . $compra->id,

                    'observacion' =>
                        'Ingreso por compra',

                    'usuario_id' => $request->usuario_id,

                    'created_at' =>
                        now()
                ]);
            }

            DB::commit();

            return response()->json([
                'message' =>
                    'Compra registrada correctamente',

                'compra' =>
                    Compra::with([
                        'proveedor',
                        'detalles.medicamento'
                    ])->find($compra->id)
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar compra',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }
}
