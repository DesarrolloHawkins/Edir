<?php

use App\Http\Controllers\AvisosController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\WhatsappController;

use App\Http\Middleware\IsAdmin;
use FontLib\Table\Type\name;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::name('inicio')->get('/', function () {
    return view('auth.login');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('is.admin');
//Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');



Route::group(['middleware' => 'is.admin', 'prefix' => 'admin'], function () {
   /* --------------------------------------- */
    // RECORDATORIO: IMPORTAR CONTROLADORES NUEVOS
    Route::get('secciones', [SeccionController::class, 'index'])->name('secciones.index');
    Route::get('secciones-create', [SeccionController::class, 'create'])->name('secciones.create');
    Route::get('secciones-edit/{id}', [SeccionController::class, 'edit'])->name('secciones.edit');
    // Registrar usuarios
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios-create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('usuarios-edit/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::get('usuarios-duplicar/{id}', [UsuarioController::class, 'duplicar'])->name('usuarios.duplicar');

    Route::get('avisos', [AvisosController::class, 'index'])->name('avisos.index');
    Route::get('avisos-create', [AvisosController::class, 'create'])->name('avisos.create');
    Route::get('avisos-edit/{id}', [AvisosController::class, 'edit'])->name('avisos.edit');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('comunidad', [ComunidadController::class, 'index'])->name('comunidad.index');
    Route::get('comunidades', [ComunidadController::class, 'indexadmin'])->name('comunidad.index.admin');


});
Route::get('/whatsapp', [WhatsappController::class, 'hookWhatsapp'])->name('whatsapp.hookWhatsapp');
Route::post('/whatsapp', [WhatsappController::class, 'processHookWhatsapp'])->name('whatsapp.processHookWhatsapp');
