<?php

namespace App\Http\Controllers\Api;

use App\Models\Personal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonalRequest;
use App\Http\Requests\UpdatePersonalRequest;

class PersonalController extends Controller
{
    public function index()
    {
        return Personal::with('usuario')
            ->orderBy('id')
            ->get();
    }

    public function show($id)
    {
        return Personal::with('usuario')
            ->findOrFail($id);
    }

    public function store(StorePersonalRequest $request)
    {
        $personal = Personal::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Personal registrado',
            'data' => $personal
        ], 201);
    }

    public function update(
        UpdatePersonalRequest $request,
        $id
    )
    {
        $personal = Personal::findOrFail($id);

        $personal->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Personal actualizado',
            'data' => $personal
        ]);
    }

    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);

        $personal->estado = false;

        $personal->save();

        return response()->json([
            'message' => 'Personal desactivado'
        ]);
    }
}
