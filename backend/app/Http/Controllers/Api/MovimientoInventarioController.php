<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovimientoInventario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovimientoInventarioController extends Controller
{
    /**
     * Listar todos los movimientos de inventario
     */
    public function index(): JsonResponse
    {
        $movimientos = MovimientoInventario::with([
            'medicamento',
            'lote',
            'tipoMovimiento',
            'usuario'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($movimientos);
    }

    /**
     * No se permite crear movimientos manualmente
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Los movimientos se generan automáticamente'
        ], 405);
    }

    /**
     * Ver detalle de un movimiento
     */
    public function show(string $id): JsonResponse
    {
        $movimiento = MovimientoInventario::with([
            'medicamento',
            'lote',
            'tipoMovimiento',
            'usuario'
        ])->find($id);

        if (!$movimiento) {
            return response()->json([
                'message' => 'Movimiento no encontrado'
            ], 404);
        }

        return response()->json($movimiento);
    }

    /**
     * No se permite editar movimientos
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json([
            'message' => 'No se permite modificar movimientos'
        ], 405);
    }

    /**
     * No se permite eliminar movimientos
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json([
            'message' => 'No se permite eliminar movimientos'
        ], 405);
    }
}
