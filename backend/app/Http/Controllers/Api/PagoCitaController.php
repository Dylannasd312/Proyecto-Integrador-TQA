<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePagoCitaRequest;
use App\Models\Cita;
use App\Models\Comprobante;
use App\Models\Pago;
use App\Models\PagoCita;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PagoCitaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            PagoCita::with([
                'pago',
                'cita'
            ])->get()
        );
    }

    public function store(
        StorePagoCitaRequest $request
    ): JsonResponse
    {
        DB::beginTransaction();

        try {

            $cita = Cita::findOrFail(
                $request->cita_id
            );

            $existePago = PagoCita::where(
                'cita_id',
                $cita->id
            )->exists();

            if ($existePago) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'La cita ya fue pagada'
                ], 422);
            }

            $pago = Pago::create([
                'paciente_id' =>
                    $cita->paciente_id,

                'metodo_pago_id' =>
                    $request->metodo_pago_id,

                'tipo_pago' =>
                    'CONSULTA',

                'monto' =>
                    $request->monto,

                'estado' =>
                    'PAGADO',

                'observaciones' =>
                    $request->observaciones,

                'usuario_id' =>
                    $request->usuario_id,

                'fecha_pago' =>
                    now()
            ]);

            $comprobante = Comprobante::create([
                'pago_id' =>
                    $pago->id,

                'numero_comprobante' =>
                    'COMP-' .
                    str_pad(
                        $pago->id,
                        8,
                        '0',
                        STR_PAD_LEFT
                    ),

                'fecha_emision' =>
                    now(),

                'total' =>
                    $request->monto,

                'observaciones' =>
                    'Pago de consulta médica'
            ]);

            PagoCita::create([
                'pago_id' =>
                    $pago->id,

                'cita_id' =>
                    $cita->id
            ]);
            $cita->update([
    'estado' => 'PENDIENTE'
]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Pago de cita registrado correctamente',

                'pago' =>
                    $pago,

                'comprobante' =>
                    $comprobante
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
