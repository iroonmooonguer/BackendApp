<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category','user')->orderBy('created_at', 'desc')->get();
      
        return new PostCollection($posts);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        // Verificar que el usuario esté autenticado
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
    
        // Generar el slug automáticamente basado en el título
        $validatedData['slug'] = Str::slug($request->title);
    
        // Añadir el user_id del usuario autenticado
        $validatedData['user_id'] = $userId;
    
        // Crear el nuevo post
        $post = Post::create($validatedData);
    
        // Cargar las relaciones necesarias
        $post->load('category');
    
        // Responder con el recurso recién creado
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //$post->load(['user','comments.user']);//Cargar Usuarios
              //  return new PostResource($post);

        $post->load('category');
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        // Actualizar el post con los datos validados
        $post->update($validatedData);

        // Cargar las relaciones necesarias
        $post->load('category');

        // Responder con el recurso actualizado
        return new PostResource($post);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

       return response()->json(null, 204);
    }

    public function myPosts()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        $posts = Post::with('category')->where('user_id', $user->id)->get();
        return PostCollection::make($posts);
    }
}
