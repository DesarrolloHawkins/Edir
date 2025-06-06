<?php

use App\Http\Controllers\AlertasController;
use App\Http\Controllers\AvisosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\ComunidadesController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Documentos\DocumentosController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PromptAsistenteController;
use App\Http\Controllers\AvisoWhatsappController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\WhatsappTemplateController;

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

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('is.admin');

Route::group(['middleware' => 'is.admin', 'prefix' => 'admin'], function () {
   /* --------------------------------------- */
    // // RECORDATORIO: IMPORTAR CONTROLADORES NUEVOS
    // Route::get('secciones', [SeccionController::class, 'index'])->name('secciones.index');
    // Route::get('secciones-create', [SeccionController::class, 'create'])->name('secciones.create');
    // Route::get('secciones-edit/{id}', [SeccionController::class, 'edit'])->name('secciones.edit');

    // Configuracion
    // Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    // Route::get('comunidad', [ComunidadController::class, 'index'])->name('comunidad.index');


    // Administrar Documentos
    // Route::get('administrar-documentos', [AdministrarDocumentosController::class, 'index'])->name('administrar.documentos.index');
    // Route::get('administrar-documentos/create', [AdministrarDocumentosController::class, 'create'])->name('administrar.documentos.create');
    // Route::post('administrar-documentos/store', [AdministrarDocumentosController::class, 'store'])->name('administrar.documentos.store');
    // Route::get('administrar-documentos/{id}/edit', [AdministrarDocumentosController::class, 'edit'])->name('administrar.documentos.edit');
    // Route::post('administrar-documentos/{id}/update', [AdministrarDocumentosController::class, 'update'])->name('administrar.documentos.update');
    // Route::post('administrar-documentos/destroy', [AdministrarDocumentosController::class, 'destroy'])->name('administrar.documentos.destroy');



    // Avisos
    Route::get('avisos', [AvisosController::class, 'index'])->name('avisos.index');
    Route::get('avisos-create', [AvisosController::class, 'create'])->name('avisos.create');
    Route::get('avisos-edit/{id}', [AvisosController::class, 'edit'])->name('avisos.edit');

    // Comunidades
    Route::get('comunidades', [ComunidadController::class, 'indexadmin'])->name('comunidad.index.admin');
    Route::prefix('comunidades')->name('comunidades.')->group(function () {
        Route::get('/', [ComunidadesController::class, 'index'])->name('index');
        Route::get('/create', [ComunidadesController::class, 'create'])->name('create');
        Route::post('/', [ComunidadesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ComunidadesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ComunidadesController::class, 'update'])->name('update');
        Route::delete('/{id}', [ComunidadesController::class, 'destroy'])->name('destroy');
    });


    // Incidencias
    Route::get('incidencias', [AvisosController::class, 'indexAdmin'])->name('incidenciasAdmin.index');
    Route::get('incidencias/{id}/show', [AvisosController::class, 'showAdmin'])->name('incidenciasAdmin.show');
    Route::put('incidencias/{id}', [AvisosController::class, 'updateAdmin'])->name('incidenciasAdmin.updateAdmin');


    // Documentos
    Route::get('documentos', [DocumentosController::class, 'indexAdmin'])->name('documentos.admin.index');
    Route::post('documentos/secciones/{id}', [DocumentosController::class, 'getSecciones'])->name('documentos.admin.getSecciones');
    Route::post('documentos/seccion/{id}', [DocumentosController::class, 'getDocumentos'])->name('documentos.admin.getDocumentos');
    Route::post('documentos/comunidad/create', [DocumentosController::class, 'createComunidad'])->name('documentos.admin.createComunidad');
    Route::post('documentos/seccion/new/create', [DocumentosController::class, 'createSeccion'])->name('documentos.admin.createSeccion');
    Route::post('documentos/upload', [DocumentosController::class, 'uploadDocument'])->name('documentos.admin.uploadDocument');
    Route::delete('documentos/{id}', [DocumentosController::class, 'delete'])->name('documentos.admin.deleteDocument');
    Route::delete('secciones/{id}', [DocumentosController::class, 'deleteSeccion'])->name('secciones.admin.deleteSeccion');

    // Registrar usuarios
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios-create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('usuarios-edit/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::get('usuarios-duplicar/{id}', [UsuarioController::class, 'duplicar'])->name('usuarios.duplicar');

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UsuariosController::class, 'index'])->name('index');
        Route::get('/create', [UsuariosController::class, 'create'])->name('create');
        Route::post('/', [UsuariosController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UsuariosController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UsuariosController::class, 'update'])->name('update');
        Route::delete('/{id}', [UsuariosController::class, 'destroy'])->name('destroy');
    });

    // Notificaciones
    Route::get('notificaciones', [NotificacionesController::class, 'index'])->name('notificaciones.index');
    Route::get('notificaciones/create', [NotificacionesController::class, 'create'])->name('notificaciones.create');
    Route::post('notificaciones', [NotificacionesController::class, 'store'])->name('notificaciones.store');
    Route::get('notificaciones/{id}/edit', [NotificacionesController::class, 'edit'])->name('notificaciones.edit');
    Route::put('notificaciones/{id}', [NotificacionesController::class, 'update'])->name('notificaciones.update');
    Route::delete('notificaciones/{id}', [NotificacionesController::class, 'destroy'])->name('notificaciones.destroy');

    Route::get('contacto/edit', [ContactoController::class, 'edit'])->name('contacto.edit');
    Route::post('/contacto', [ContactoController::class, 'update'])->name('contacto.update');

    Route::prefix('config')->name('config.')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('index');
        Route::get('/whatsapp', [WhatsappController::class, 'whatsapp'])->name('whatsapp');
        // Route::get('/whatsapp-templates', [ConfiguracionController::class, 'templates'])->name('whatsapp.templates');
        // Route::get('/mantenimiento', [ConfiguracionController::class, 'mantenimiento'])->name('mantenimiento');
        // Route::get('/avisos', [ConfiguracionController::class, 'avisos'])->name('avisos');

        Route::get('/config/prompt', [PromptAsistenteController::class, 'index'])->name('prompt');
        Route::post('/config/prompt', [PromptAsistenteController::class, 'store'])->name('prompt.store');
        Route::put('/config/prompt/{id}', [PromptAsistenteController::class, 'update'])->name('prompt.update');

        Route::resource('avisos-whatsapp', AvisoWhatsappController::class);

        Route::resource('mantenimiento', MantenimientoController::class)->names('mantenimiento');

        Route::get('/whatsapp-templates', [WhatsappTemplateController::class, 'index'])->name('whatsapp.templates');
        Route::get('/whatsapp-templates/create', [WhatsappTemplateController::class, 'create'])->name('whatsapp.templates.create');
        Route::post('/whatsapp-templates', [WhatsappTemplateController::class, 'store'])->name('whatsapp.templates.store');
        Route::get('/whatsapp-templates/sync', [WhatsappTemplateController::class, 'sync'])->name('whatsapp.templates.sync');
        Route::get('/whatsapp-templates/{template}/status', [WhatsappTemplateController::class, 'checkStatus'])->name('whatsapp.templates.checkStatus');
        Route::get('/whatsapp-templates/{template}', [WhatsappTemplateController::class, 'show'])->name('whatsapp.templates.show');
        Route::get('/whatsapp-templates/{template}/edit', [WhatsappTemplateController::class, 'edit'])->name('whatsapp.templates.edit');
        Route::put('/whatsapp-templates/{template}', [WhatsappTemplateController::class, 'update'])->name('whatsapp.templates.update');


        // routes/web.php




    });

});
Route::middleware(['auth'])->group(function () {

    // Documentos
    Route::get('documentos', [DocumentosController::class, 'index'])->name('documentos.index');
    Route::get('documentos/{id}/seccion', [DocumentosController::class, 'show'])->name('documentos.seccion.show');
    Route::post('documentos/getDocumentos/{id}', [DocumentosController::class, 'getDocumentosUser'])->name('documentosUser.getDocumentos');

    // Incidencias
    Route::get('incidencias', [AvisosController::class, 'index'])->name('incidencias.index');
    Route::get('incidencias/{id}/show', [AvisosController::class, 'show'])->name('incidencias.show');
    Route::get('incidencias/create', [AvisosController::class, 'create'])->name('incidencias.create');
    Route::post('incidencias', [AvisosController::class, 'store'])->name('incidencias.store');
    Route::get('incidencias/{id}/edit', [AvisosController::class, 'edit'])->name('incidencias.edit');
    Route::put('incidencias/{id}', [AvisosController::class, 'update'])->name('incidencias.update');

    // Perfil de usuario
    Route::get('perfil', [UsuarioController::class, 'perfil'])->name('perfil.index');
    Route::put('perfil', [UsuarioController::class, 'actualizarPerfil'])->name('perfil.update');
    Route::put('perfil/password', [UsuarioController::class, 'actualizarPassword'])->name('perfil.updatePassword');

    Route::get('/alertas/no-leidas', [App\Http\Controllers\AlertasController::class, 'alertasNoLeidas'])->name('alertas.noLeidas');
    Route::post('/alertas/marcar-leidas', [AlertasController::class, 'marcarAlertasComoLeidas'])->name('alertas.marcarLeidas');

    Route::get('/contacto', [ContactoController::class, 'form'])->name('contacto.form');


});

Route::get('/whatsapp', [WhatsappController::class, 'hookWhatsapp'])->name('whatsapp.hookWhatsapp');
Route::post('/whatsapp', [WhatsappController::class, 'processHookWhatsapp'])->name('whatsapp.processHookWhatsapp');
