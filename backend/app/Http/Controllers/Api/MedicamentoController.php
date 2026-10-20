<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicamentoRequest;
use App\Http\Requests\UpdateMedicamentoRequest;
use App\Models\Medicamento;
use Illuminate\Http\JsonResponse;

class MedicamentoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Medicamento::orderBy('nombre')->get()
        );
    }

    public function store(
        StoreMedicamentoRequest $request
    ): JsonResponse
    {
        $medicamento = Medicamento::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Medicamento registrado correctamente',
            'data' => $medicamento
        ], 201);
    }

    public function show(
        Medicamento $medicamento
    ): JsonResponse
    {
        return response()->json($medicamento);
    }

    public function update(
        UpdateMedicamentoRequest $request,
        Medicamento $medicamento
    ): JsonResponse
    {
        $medicamento->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Medicamento actualizado correctamente',
            'data' => $medicamento
        ]);
    }

    public function destroy(
        Medicamento $medicamento
    ): JsonResponse
    {
        $medicamento->delete();

        return response()->json([
            'message' => 'Medicamento eliminado correctamente'
        ]);
    }
}
