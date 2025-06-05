<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use App\Models\Comunidad;
use App\Models\Documentos;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alertas;
use App\Models\User;

class DocumentosController extends Controller
{
    public function indexAdmin(){
        $comunidades = Comunidad::all();
        //if(!$comunidad) return view('noFound');

        //$secciones = Seccion::all();
        return view('admin.documentos.index', compact('comunidades'));

    }

    public function getSecciones($id){
        $comunidad = Comunidad::find($id);
        if (!$comunidad) {
            return response()->json([
                'status' => false,
                'mensaje' => 'No se encontraron comunidad disponible con esa id.',
            ]);
        }

        $secciones = Seccion::where('comunidad_id', $id)->get();

        if (count($secciones) > 0) {
            return response()->json([
                'status' => true,
                'data' => $secciones,
            ]);
        }

        return response()->json([
            'status' => false,
            'mensaje' => 'No se encontraron secciones disponible para la comunidad.',
        ]);
    }
    public function getDocumentosUser($id)
    {
        $seccion = Seccion::find($id);
        if (!$seccion) {
            return response()->json([
                'status' => false,
                'mensaje' => 'No se encontró la sección con esa id.',
            ]);
        }

        $documentos = Documentos::where('seccion_id', $id)->get();

        if (count($documentos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $documentos,
            ]);
        }

        return response()->json([
            'status' => false,
            'mensaje' => 'No se encontraron documentos disponibles para la sección.',
        ]);
    }


    public function getDocumentos($id)
    {
        $seccion = Seccion::find($id);
        if (!$seccion) {
            return response()->json([
                'status' => false,
                'mensaje' => 'No se encontró la sección con esa id.',
            ]);
        }

        $documentos = Documentos::where('seccion_id', $id)->get();

        if (count($documentos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $documentos,
            ]);
        }

        return response()->json([
            'status' => false,
            'mensaje' => 'No se encontraron documentos disponibles para la sección.',
        ]);
    }


    public function uploadDocument(Request $request)
    {
        $request->validate([
            'comunidad_id' => 'required|exists:comunidad,id',
            'seccion_id' => 'required|exists:secciones,id',
            'file' => 'required|file|max:2048|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documentos', $fileName, 'public');

        $documento = Documentos::create([
            'comunidad_id' => $request->comunidad_id,
            'seccion_id' => $request->seccion_id,
            'nombre' => $file->getClientOriginalName(),
            'ruta_imagen' => $filePath,
            'fecha' => now(),
        ]);

        // Crear la alerta
        $alerta = Alertas::create([
            'admin_user_id' => Auth::id(),
            'titulo' => 'Nuevo documento disponible',
            'tipo' => 'documento',
            'datetime' => now(),
            'descripcion' => 'Se ha subido un nuevo documento: ' . $documento->nombre,
            'url' => route('documentos.seccion.show', $request->seccion_id),
            'comunidad_id' => $request->comunidad_id,
        ]);

        // Obtener todos los usuarios de esa comunidad
        $usuarios = User::where('comunidad_id', $request->comunidad_id)->get();

        // Asociar alerta a cada usuario con status = 0 (no leída)
        foreach ($usuarios as $usuario) {
            $alerta->users()->attach($usuario->id, ['status' => 0]);
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Documento subido con éxito.',
        ]);
    }

    public function createSeccion(Request $request)
    {
        $request->validate([
            'comunidad_id' => 'required|exists:comunidad,id',
            'nombre' => 'required|string|max:255',
            // 'seccion_padre_id' => 'nullable|exists:secciones,id',
            'orden' => 'nullable|integer|min:1',
        ]);

        $seccion = Seccion::create([
            'comunidad_id' => $request->comunidad_id,
            'seccion_padre_id' => $request->seccion_padre_id ?? null,
            'nombre' => $request->nombre,
            'orden' => $request->orden ?? 1,
        ]);

        return response()->json([
            'status' => true,
            'mensaje' => 'Sección creada con éxito.',
            'data' => $seccion,
        ]);
    }

    public function createComunidad(Request $request)
    {
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ruta_imagen' => 'nullable|image|max:2048',
            'informacion_adicional' => 'nullable|string',
            'codigo' => 'required|string|max:10|unique:comunidad,codigo',
        ]);

        $rutaImagen = null;
        if ($request->hasFile('ruta_imagen')) {
            $file = $request->file('ruta_imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $rutaImagen = $file->storeAs('comunidades', $fileName, 'public');
        }

        $comunidad = Comunidad::create([
            'user_id' => Auth::user()->id,
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'ruta_imagen' => $rutaImagen,
            'informacion_adicional' => $request->informacion_adicional,
            'codigo' => $request->codigo,
        ]);

        return response()->json([
            'status' => true,
            'mensaje' => 'Comunidad creada con éxito.',
            'data' => $comunidad,
        ]);
    }

    public function delete($id)
    {
        $documento = Documentos::find($id);

        if (!$documento) {
            return response()->json([
                'status' => false,
                'message' => 'Documento no encontrado.',
            ], 404);
        }

        try {
            // Eliminar el archivo físico si existe
            if ($documento->ruta_imagen && file_exists(public_path($documento->ruta_imagen))) {
                unlink(public_path($documento->ruta_imagen));
            }

            // Eliminar el registro de la base de datos
            $documento->delete();

            return response()->json([
                'status' => true,
                'message' => 'Documento eliminado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Hubo un error al intentar eliminar el documento.',
            ], 500);
        }
    }

    public function deleteSeccion($id)
    {
        $seccion = Seccion::find($id);

        if (!$seccion) {
            return response()->json([
                'status' => false,
                'message' => 'Sección no encontrada.',
            ], 404);
        }

        try {
            // Eliminar secciones hijas asociadas
            $seccion->seccionesHijas()->delete();

            // Eliminar la sección principal
            $seccion->delete();

            return response()->json([
                'status' => true,
                'message' => 'Sección eliminada correctamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Hubo un error al intentar eliminar la sección.',
            ], 500);
        }
    }




    // User
    public function index(){
        $user = Auth::user();
        if(!$user) return view('noAutorizado');

        $comunidad = Comunidad::find($user->comunidad_id);
        if(!$comunidad) return view('noFound');

        $secciones = Seccion::where('comunidad_id', $comunidad->id)->get();

        return view('administrar.documentos.index', compact('secciones'));
    }

    public function show($id){
        $user = Auth::user();
        if(!$user) return view('noAutorizado');

        $comunidad = Comunidad::find($user->comunidad_id)->first();
        if(!$comunidad) return view('noFound');

        $seccion = Seccion::find($id);
        if(!$seccion) return view('noFound');

        $documentos = Documentos::where('seccion_id', $id)->get();

        return view('administrar.documentos.show', compact('documentos', 'seccion'));
    }

}
