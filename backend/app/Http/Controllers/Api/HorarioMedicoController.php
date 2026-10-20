<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHorarioMedicoRequest;
use App\Http\Requests\UpdateHorarioMedicoRequest;
use App\Models\HorarioMedico;
use App\Models\Medico;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HorarioMedicoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            HorarioMedico::with([
                'medico',
                'especialidad',
                'consultorio',
                'diaSemana'
            ])
            ->where('estado', true)
            ->orderBy('id')
            ->get()
        );
    }

    public function store(
        StoreHorarioMedicoRequest $request
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $medico = Medico::with(
                'especialidades'
            )->findOrFail(
                $request->medico_id
            );

            $tieneEspecialidad =
                $medico->especialidades()
                ->where(
                    'especialidades.id',
                    $request->especialidad_id
                )
                ->exists();

            if (!$tieneEspecialidad) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'La especialidad no pertenece al médico'
                ], 422);
            }

            $solapado = HorarioMedico::where(
                'medico_id',
                $request->medico_id
            )
            ->where(
                'dia_semana_id',
                $request->dia_semana_id
            )
            ->where(
                'estado',
                true
            )
            ->where(function ($query) use ($request) {

                $query
                    ->whereBetween(
                        'hora_inicio',
                        [
                            $request->hora_inicio,
                            $request->hora_fin
                        ]
                    )
                    ->orWhereBetween(
                        'hora_fin',
                        [
                            $request->hora_inicio,
                            $request->hora_fin
                        ]
                    )
                    ->orWhere(function ($q) use ($request) {

                        $q->where(
                            'hora_inicio',
                            '<=',
                            $request->hora_inicio
                        )
                        ->where(
                            'hora_fin',
                            '>=',
                            $request->hora_fin
                        );
                    });
            })
            ->exists();

            if ($solapado) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'Existe un horario que se superpone'
                ], 422);
            }

            $horario = HorarioMedico::create([

                'medico_id' =>
                    $request->medico_id,

                'especialidad_id' =>
                    $request->especialidad_id,

                'consultorio_id' =>
                    $request->consultorio_id,

                'dia_semana_id' =>
                    $request->dia_semana_id,

                'hora_inicio' =>
                    $request->hora_inicio,

                'hora_fin' =>
                    $request->hora_fin,

                'estado' =>
                    $request->estado ?? true
            ]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Horario registrado correctamente',

                'data' =>
                    $horario->load([
                        'medico',
                        'especialidad',
                        'consultorio',
                        'diaSemana'
                    ])
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar horario',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function show(
        $id
    ): JsonResponse {

        $horario = HorarioMedico::with([
            'medico',
            'especialidad',
            'consultorio',
            'diaSemana'
        ])->findOrFail($id);

        return response()->json(
            $horario
        );
    }

    public function update(
        UpdateHorarioMedicoRequest $request,
        $id
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $horario = HorarioMedico::findOrFail(
                $id
            );

            $data = array_merge(
                $horario->toArray(),
                $request->validated()
            );

            $medico = Medico::with(
                'especialidades'
            )->findOrFail(
                $data['medico_id']
            );

            $tieneEspecialidad =
                $medico->especialidades()
                ->where(
                    'especialidades.id',
                    $data['especialidad_id']
                )
                ->exists();

            if (!$tieneEspecialidad) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'La especialidad no pertenece al médico'
                ], 422);
            }

            $solapado = HorarioMedico::where(
                'medico_id',
                $data['medico_id']
            )
            ->where(
                'dia_semana_id',
                $data['dia_semana_id']
            )
            ->where(
                'estado',
                true
            )
            ->where(
                'id',
                '!=',
                $horario->id
            )
            ->where(function ($query) use ($data) {

                $query
                    ->whereBetween(
                        'hora_inicio',
                        [
                            $data['hora_inicio'],
                            $data['hora_fin']
                        ]
                    )
                    ->orWhereBetween(
                        'hora_fin',
                        [
                            $data['hora_inicio'],
                            $data['hora_fin']
                        ]
                    )
                    ->orWhere(function ($q) use ($data) {

                        $q->where(
                            'hora_inicio',
                            '<=',
                            $data['hora_inicio']
                        )
                        ->where(
                            'hora_fin',
                            '>=',
                            $data['hora_fin']
                        );
                    });
            })
            ->exists();

            if ($solapado) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'Existe un horario que se superpone'
                ], 422);
            }

            $horario->update(
                $request->validated()
            );

            DB::commit();

            return response()->json([
                'message' =>
                    'Horario actualizado correctamente',

                'data' =>
                    $horario->fresh()->load([
                        'medico',
                        'especialidad',
                        'consultorio',
                        'diaSemana'
                    ])
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al actualizar horario',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function destroy(
        $id
    ): JsonResponse {

        $horario = HorarioMedico::findOrFail(
            $id
        );

        $horario->update([
            'estado' => false
        ]);

        return response()->json([
            'message' =>
                'Horario desactivado correctamente'
        ]);
    }
}
