<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        /* return Post::with('coments', 'likes','user.coments')->get();*/
        $posts = Post::orderBy('id', 'desc')->with('user', 'likes', 'comments.user')->get();
        return response($posts, 201);
    }

    public function like(Request $request)
    {
        try {
            $body = Validator::make($request->all(), [
                'id_post' => 'required',
                'id_user' => 'required'
            ]);
            $like = Like::create($request->all());
            $nLike = Post::find($request->id_post)->likes()->count();
            return response(['msg' => 'Correcto', 'like' => $like, 'nLike' => $nLike], 201);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    public function dislike(Request $request)
    {
        $body = Validator::make($request->all(), [
            'id_post' => 'required',
            'id_user' => 'required'
        ]);
        $dislike = Like::where('id_user', '=', $request['id_user'])
            ->where('id_post', '=', $request['id_post'])->delete();
        $nDislike = Post::find($request->id_post)->likes()->count();
        return response(['msg' => 'Correcto', 'dislike' => $dislike, 'nDislike' => $nDislike]);
    }

    public function allFollows($id)
    {
        return User::find($id)->followers()->get();
    }

    public function getPostsPerfil($id)
    {
        return Post::where('id_user', '=', $id)->with('user', 'likes', 'comments.user')->get();
    }

    public function newPost(Request $request)
    {
        try {
            $body = $request->validate([
                'titulo' => 'required| string',
                'imagen' => 'image'
            ]);
            $nombre = time() . "_" . request()->imagen->getClientOriginalName();
            request()->imagen->move('img', $nombre);
            $body['imagen'] = $nombre;
            $body['id_user'] = Auth::id();
            $post = Post::create($body);
            return response(['msg' => 'correcto', 'body' => $post]);
        } catch (\Exception $e) {
            return response([
                'error' => $e,
            ], 500);
        }
    }
    public function deletePost($id)
    {
        $post = Post::find($id);
        $delete = $post->delete();
        return $delete;
    }
    public function updatePost(Request $request, $id){
        $body = $request->validate([
            'titulo' => 'required| string',
            'imagen' => 'required|image'
        ]);
        $post = Post::find($id);
        $nombre = time() . "_" . request()->imagen->getClientOriginalName();
        request()->imagen->move('img', $nombre);
        $post->imagen = $nombre;
        $post->titulo = $request->titulo;
        $post->update();
        return $post;

    }

} // Cierre final
