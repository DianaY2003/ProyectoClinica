<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\CitaClienteController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\RecetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('citas',CitaController::class);
Route::resource('publicas',CitaClienteController::class);



Route::get('citas/expediente/{id}', [CitaController::class, 'expedientePaciente']);
Route::get('citas/consulta/{id}', [CitaController::class, 'consultaPaciente']);
Route::resource('pacientes',PacienteController::class);
Route::resource('usuarios',UserController::class);
Route::resource('distritos',DistritoController::class);
Route::resource('tratamientos',TratamientoController::class);
Route::resource('doctores',DoctorController::class);
Route::resource('pagos',PagoController::class);
Route::resource('medicamentos',MedicamentoController::class);
Route::resource('recetas',RecetaController::class);
Route::post('/recetas/{cita_id}', [RecetaController::class, 'store']);
Route::get('/recetas/show/{cita_id}', [RecetaController::class, 'show']);

