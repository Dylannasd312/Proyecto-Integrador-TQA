<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CierreCaja;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CierreCajaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            CierreCaja::with('usuario')
                ->orderByDesc('fecha')
                ->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'usuario_id' => 'required|exists:usuarios,id',
                'fecha' => 'required|date',
                'observaciones' => 'nullable|string'
            ]);

            $existeCierre = CierreCaja::where(
                'usuario_id',
                $request->usuario_id
            )->where(
                'fecha',
                $request->fecha
            )->exists();

            if ($existeCierre) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'Ya existe un cierre para esta fecha'
                ], 422);
            }

            $totalEfectivo = Pago::whereDate(
                'fecha_pago',
                $request->fecha
            )
                ->where(
                    'estado',
                    'PAGADO'
                )
                ->where(
                    'metodo_pago_id',
                    1
                )
                ->sum('monto');

            $totalQr = Pago::whereDate(
                'fecha_pago',
                $request->fecha
            )
                ->where(
                    'estado',
                    'PAGADO'
                )
                ->where(
                    'metodo_pago_id',
                    2
                )
                ->sum('monto');

            $totalGeneral =
                $totalEfectivo +
                $totalQr;

            $cierre = CierreCaja::create([
                'usuario_id' =>
                    $request->usuario_id,

                'fecha' =>
                    $request->fecha,

                'total_efectivo' =>
                    $totalEfectivo,

                'total_qr' =>
                    $totalQr,

                'total_general' =>
                    $totalGeneral,

                'observaciones' =>
                    $request->observaciones,

                'created_at' =>
                    now()
            ]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Cierre de caja registrado correctamente',

                'cierre' =>
                    $cierre
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar cierre',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        return response()->json(
            CierreCaja::with('usuario')
                ->findOrFail($id)
        );
    }

    public function update(
        Request $request,
        string $id
    ): JsonResponse
    {
        return response()->json([
            'message' =>
                'Los cierres de caja no pueden modificarse'
        ], 405);
    }

    public function destroy(string $id): JsonResponse
    {
        return response()->json([
            'message' =>
                'Los cierres de caja no pueden eliminarse'
        ], 405);
    }
}
