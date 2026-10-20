<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecetaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\MedicoController;
use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\HistoriaClinicaController;
use App\Http\Controllers\Api\ConsultorioController;
use App\Http\Controllers\Api\CitaController;
use App\Http\Controllers\Api\ConsultaController;
use App\Http\Controllers\Api\SignosVitalesController;
use App\Http\Controllers\Api\ArchivoClinicoController;
use App\Http\Controllers\Api\AnalisisIAController;
use App\Http\Controllers\Api\MedicamentoController;
use App\Http\Controllers\Api\PagoRecetaController;
use App\Http\Controllers\Api\DespachoRecetaController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\CompraController;
use App\Http\Controllers\Api\PagoCitaController;
use App\Http\Controllers\Api\HorarioMedicoController;
use App\Http\Controllers\Api\BloqueoHorarioController;
use App\Http\Controllers\Api\EspecialidadController;
use App\Http\Controllers\Api\MovimientoInventarioController;
use App\Http\Controllers\Api\HistorialCitaController;
use App\Http\Controllers\Api\CierreCajaController;
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource(
        'usuarios',
        UsuarioController::class
    );

    Route::apiResource(
        'personal',
        PersonalController::class
    );

    Route::apiResource(
        'medicos',
        MedicoController::class
    );

    Route::apiResource(
        'pacientes',
        PacienteController::class
    );

    Route::apiResource(
        'consultorios',
        ConsultorioController::class
    );

    Route::apiResource(
        'citas',
        CitaController::class
    );

    Route::apiResource(
        'consultas',
        ConsultaController::class
    );

    Route::apiResource(
        'signos-vitales',
        SignosVitalesController::class
    );

    Route::apiResource(
        'archivos-clinicos',
        ArchivoClinicoController::class
    );

    Route::apiResource(
        'analisis-ia',
        AnalisisIAController::class
    );

    Route::get(
        '/historias-clinicas',
        [HistoriaClinicaController::class, 'index']
    );

    Route::get(
        '/historias-clinicas/{id}',
        [HistoriaClinicaController::class, 'show']
    );

    Route::put(
        '/historias-clinicas/{id}',
        [HistoriaClinicaController::class, 'update']
    );
    Route::apiResource(
    'recetas',
    RecetaController::class
);
Route::apiResource(
    'medicamentos',
    MedicamentoController::class
);
Route::resource(
    'pago-recetas',
    PagoRecetaController::class
);
    Route::post(
    'despachos-receta',
    [DespachoRecetaController::class, 'store']
);
Route::apiResource(
    'proveedores',
    ProveedorController::class
);
Route::apiResource(
    'compras',
    CompraController::class
);
Route::apiResource(
    'pago-citas',
    PagoCitaController::class
);
Route::apiResource(
    'horarios-medicos',
    HorarioMedicoController::class
);
Route::apiResource(
    'bloqueos-horario',
    BloqueoHorarioController::class
);
Route::apiResource(
    'especialidades',
    EspecialidadController::class
);
Route::apiResource(
    'movimientos-inventario',
    MovimientoInventarioController::class
);
Route::apiResource(
    'cierres-caja',
    CierreCajaController::class
);
Route::apiResource(
    'historial-citas',
    HistorialCitaController::class
);
});
