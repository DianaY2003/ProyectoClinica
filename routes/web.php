<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CitaClienteController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/resources/views/inicio.blade.php', function () {
    return view('publica.inicio');
});

Route::get('/resources/views/cita.blade.php', function(){
    return view('publica.cita');
});

Route::get('/resources/views/nosotros.blade.php', function(){
    return view('publica.nosotros');
});

Route::get('/resources/views/trabajosD.blade.php', function(){
    return view('publica.trabajosD');
});

Route::get('/resources/views/ubicacion.blade.php', function(){
    return view('publica.ubicacion');
});

Route::get('/resources/views/auth/login.blade.php', function(){
    return view('auth.login');
});

Route::get('/resources/views/auth/register.blade.php', function(){
    return view('auth.register');
});
Route::get('/odontograma/{pacienteId}', function () {
    return view('agenda.odontograma');
})->name('odontograma');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/agenda', [CitaController::class, 'agenda'])->name('agenda.agenda');
Route::get('reportes/pacientes',[PDFController::class,'getPacientes'])->name('reportes.pacientes');
Route::get('/expediente/{id}', [CitaController::class, 'showExpediente'])->name('agenda.expediente');
Route::get('/consulta/{id}', [CitaController::class, 'consulta'])->name('agenda.consulta');

Route::get('/publicas', [CitaClienteController::class, 'index'])->name('publicas');
Route::post('/publicas/agregar', [CitaClienteController::class,'store']);
Route::get('/publicas/mostrar', [CitaClienteController::class,'show']);
Route::post('/publicas/{id}', [CitaClienteController::class,'edit']);
Route::delete('/publicas/{id}', [CitaClienteController::class, 'delete']);

//para reportes
Route::get('reportes/pagos/rango',[PDFController::class,'getPagos'])->name('reportes.pagos');
Route::get('reportes/pagos',[PDFController::class,'viewPagos'])->name('reportes.view');
Route::get('/recetas/{id}/pdf', [PDFController::class, 'generarRecetaPDF'])->name('recetas.pdf');
