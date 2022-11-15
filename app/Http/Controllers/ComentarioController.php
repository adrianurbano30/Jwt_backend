<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ComentarioResource;
use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function storeComentario(Request $request){

        $usuario=$request->usuario_id;
        $publicacion=Publicacion::find($request->publicacion_id);
        $comentario=$request->comentario;
        $usuarioAuth=Auth::user();
        $comment;

        if ($usuarioAuth->id==$usuario) {
            $comment = $publicacion->comentarios()->create([
                'user_id'=>$usuario,
                'comentarios'=>$comentario,
                'editado'=>false
            ]);
        }

        return new ComentarioResource($comment);

    }
    public function updateComentario(Request $request){
        $comentario=Comentario::find($request->id);
        $usuarioAuth=Auth::user();
        $usuario=$request->User;

        $comentario->update([
            'user_id'=>$usuarioAuth->id,
            'comentarios'=>$request->comentarios,
            'editado'=>true,
        ]);

        return new ComentarioResource($comentario);
    }
    public function destroyComentario(Request $request){

        $comentario= Comentario::find($request->id);

        $comentario->delete();

        return $request->id;
    }
    //RESPUESTAS COMENTARIO/////
    public function storeRespuestaComentario(Request $request){

        $usuarioAuth=Auth::user();
        //$respuesta = json_encode($request->comentarios);
        $respuesta = $request->comentarios;
        $comentario = Comentario::find($request->id);

        $response = $comentario->replies()->create([
            'user_id'=>$usuarioAuth->id,
            'comentarios'=>$respuesta,
            'editado'=>false
        ]);

        return new ComentarioResource($response);
    }
    public function updateRespuestaComentario(Request $request){
        $usuarioAuth=Auth::user();
        $respuesta = $request->comentarios;
        $resp = Comentario::find($request->id);
        $resp->update([
            'user_id'=>$usuarioAuth->id,
            'comentarios'=>$respuesta,
            'editado'=>true
        ]);
        return new ComentarioResource($resp);
    }
    public function destroyRespuesta(Request $request){
        $usuarioAuth=Auth::user();
        $respuesta=Comentario::find($request->id);
        $respuesta->delete();
        return $respuesta;
    }
    //END RESPUESTAS COMENTARIO
}
