<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsultaRequest;
use App\Http\Requests\UpdateConsultaRequest;
use App\Models\Consulta;
use App\Models\Cita;
use App\Models\HistorialCita;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Consulta::with([
                'cita',
                'paciente',
                'medico',
                'especialidad',
                'signosVitales',
                'archivosClinicos',
                'analisisIA',
                'receta'
            ])
            ->orderBy('id')
            ->get()
        );
    }

    public function store(
        StoreConsultaRequest $request
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $cita = Cita::findOrFail(
                $request->cita_id
            );

            if (
                $cita->estado ===
                'POR_PAGAR'
            ) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'La cita debe ser pagada antes de iniciar la consulta'
                ], 422);
            }

            if ($cita->consulta) {

                DB::rollBack();

                return response()->json([
                    'message' =>
                        'La cita ya tiene una consulta registrada'
                ], 422);
            }

            $consulta = Consulta::create([
                'cita_id' =>
                    $request->cita_id,

                'paciente_id' =>
                    $request->paciente_id,

                'medico_id' =>
                    $request->medico_id,

                'especialidad_id' =>
                    $request->especialidad_id,

                'motivo_consulta' =>
                    $request->motivo_consulta,

                'enfermedad_actual' =>
                    $request->enfermedad_actual,

                'diagnostico' =>
                    $request->diagnostico,

                'tratamiento' =>
                    $request->tratamiento,

                'observaciones' =>
                    $request->observaciones,

                'estado' =>
                    $request->estado ?? 'EN_CURSO',

                'fecha_consulta' =>
                    now()
            ]);

            $estadoAnterior = $cita->estado;

$cita->update([
    'estado' => 'EN_CONSULTA'
]);

HistorialCita::create([
    'cita_id' => $cita->id,
    'estado_anterior' => $estadoAnterior,
    'estado_nuevo' => 'EN_CONSULTA',
    'observacion' => 'Inicio de consulta médica',
    'usuario_id' => null,
    'created_at' => now()
]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Consulta médica creada correctamente',

                'data' =>
                    $consulta->load([
                        'cita',
                        'paciente',
                        'medico',
                        'especialidad'
                    ])
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al registrar consulta',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function show(
        $id
    ): JsonResponse {

        $consulta = Consulta::with([
            'cita',
            'paciente',
            'medico',
            'especialidad',
            'signosVitales',
            'archivosClinicos',
            'analisisIA',
            'receta'
        ])->findOrFail($id);

        return response()->json(
            $consulta
        );
    }

    public function update(
        UpdateConsultaRequest $request,
        $id
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $consulta = Consulta::findOrFail($id);

            $consulta->update(
                $request->validated()
            );

            if (
    $consulta->estado ===
    'FINALIZADA'
) {

    $estadoAnterior =
        $consulta->cita->estado;

    $consulta->cita()->update([
        'estado' => 'FINALIZADA'
    ]);

    HistorialCita::create([
        'cita_id' => $consulta->cita_id,
        'estado_anterior' => $estadoAnterior,
        'estado_nuevo' => 'FINALIZADA',
        'observacion' => 'Consulta finalizada',
        'usuario_id' => null,
        'created_at' => now()
    ]);
}

            if (
    $consulta->estado ===
    'CANCELADA'
) {

    $estadoAnterior =
        $consulta->cita->estado;

    $consulta->cita()->update([
        'estado' => 'CANCELADA'
    ]);


    HistorialCita::create([
        'cita_id' => $consulta->cita_id,
        'estado_anterior' => $estadoAnterior,
        'estado_nuevo' => 'CANCELADA',
        'observacion' => 'Consulta cancelada',
        'usuario_id' => null,
        'created_at' => now()
    ]);
}

            DB::commit();

            return response()->json([
                'message' =>
                    'Consulta actualizada correctamente',

                'data' =>
                    $consulta->fresh()->load([
                        'cita',
                        'paciente',
                        'medico',
                        'especialidad',
                        'signosVitales',
                        'archivosClinicos',
                        'analisisIA',
                        'receta'
                    ])
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al actualizar consulta',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }

    public function destroy(
        $id
    ): JsonResponse {

        DB::beginTransaction();

        try {

            $consulta = Consulta::findOrFail($id);

            $estadoAnterior = $consulta->cita->estado;

$consulta->update([
    'estado' => 'CANCELADA'
]);

$consulta->cita()->update([
    'estado' => 'CANCELADA'
]);

HistorialCita::create([
    'cita_id' => $consulta->cita_id,
    'estado_anterior' => $estadoAnterior,
    'estado_nuevo' => 'CANCELADA',
    'observacion' => 'Consulta cancelada desde destroy',
    'usuario_id' => null,
    'created_at' => now()
]);

            DB::commit();

            return response()->json([
                'message' =>
                    'Consulta cancelada correctamente'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' =>
                    'Error al cancelar consulta',

                'error' =>
                    $e->getMessage()
            ], 500);
        }
    }
}
