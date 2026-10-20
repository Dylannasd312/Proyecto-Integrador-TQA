<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\JsonResponse;

class ProveedorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Proveedor::all()
        );
    }

    public function store(
        StoreProveedorRequest $request
    ): JsonResponse
    {
        $proveedor = Proveedor::create(
            $request->validated()
        );

        return response()->json([
            'message' =>
                'Proveedor registrado correctamente',

            'data' =>
                $proveedor
        ], 201);
    }

    public function show(
        Proveedor $proveedor
    ): JsonResponse
    {
        return response()->json(
            $proveedor
        );
    }

    public function update(
        UpdateProveedorRequest $request,
        Proveedor $proveedor
    ): JsonResponse
    {
        $proveedor->update(
            $request->validated()
        );

        return response()->json([
            'message' =>
                'Proveedor actualizado correctamente',

            'data' =>
                $proveedor->fresh()
        ]);
    }

    public function destroy(
        Proveedor $proveedor
    ): JsonResponse
    {
        $proveedor->update([
            'estado' => false
        ]);

        return response()->json([
            'message' =>
                'Proveedor desactivado correctamente'
        ]);
    }
}
