<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSignosVitalesRequest;
use App\Http\Requests\UpdateSignosVitalesRequest;
use App\Models\SignosVitales;

class SignosVitalesController extends Controller
{
    public function index()
    {
        return response()->json(
            SignosVitales::with('consulta')
                ->orderBy('id')
                ->get()
        );
    }

    public function show($id)
    {
        $signos = SignosVitales::with('consulta')
            ->findOrFail($id);

        return response()->json($signos);
    }

    public function store(StoreSignosVitalesRequest $request)
    {
        $datos = $request->validated();

        if (
            isset($datos['peso']) &&
            isset($datos['talla']) &&
            $datos['talla'] > 0
        ) {
            $datos['imc'] =
                $datos['peso'] /
                ($datos['talla'] * $datos['talla']);
        }

        $signos = SignosVitales::create($datos);

        return response()->json([
            'message' => 'Signos vitales registrados correctamente',
            'data' => $signos
        ], 201);
    }

    public function update(
        UpdateSignosVitalesRequest $request,
        $id
    ) {
        $signos = SignosVitales::findOrFail($id);

        $datos = $request->validated();

        if (
            isset($datos['peso']) &&
            isset($datos['talla']) &&
            $datos['talla'] > 0
        ) {
            $datos['imc'] =
                $datos['peso'] /
                ($datos['talla'] * $datos['talla']);
        }

        $signos->update($datos);

        return response()->json([
            'message' => 'Signos vitales actualizados correctamente',
            'data' => $signos
        ]);
    }

    public function destroy($id)
    {
        $signos = SignosVitales::findOrFail($id);

        $signos->delete();

        return response()->json([
            'message' => 'Signos vitales eliminados correctamente'
        ]);
    }
}
