<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Comment;

class CommentController extends Controller {

    // Guardar un nuevo comentario
    public function createComment( Request $request ) {

        $validatedData = $request->validate( [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'img_url' => 'nullable|url',
            'project_id' => 'required|exists:projects,id',
        ] );

        $comment = new Comment( $validatedData );
        $comment->save();

        return redirect()->back();
    }

    // Actualizar un comentario
    public function editComment( Request $request) {

    
        $validatedData = $request->validate( [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'img_url' => 'nullable|url',
            'project_id' => 'required|exists:projects,id',
       
        ] );

        $id = $request->input( 'id' );
        $comment = Comment::find( $id );
        
        $comment->title = $validatedData[ 'title' ];
        $comment->description = $validatedData[ 'description' ];
        $comment->img_url = $validatedData[ 'img_url' ];
        $comment->project_id = $validatedData[ 'project_id' ];
       
        $comment->save();

        return redirect()->back();
    }

    // Eliminar un comentario
    public function deleteComment($id) {
        $comment = Comment::find($id);
        $comment->delete();
    }

    // ============================REACT============================

    // Metodo para mostrar los comentarios de un proyecto
    public function getComments( $id ) {
        $comments = Comment::where( 'project_id', $id )->get();
        return response()->json( $comments );
    }

    

}