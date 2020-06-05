<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
       /* return Post::with('coments', 'likes','user.coments')->get();*/
        $posts = Post::orderBy('id','desc')->with('user','likes','comments.user')->get();
        return response($posts, 201);
    }
    public function like(Request $request){
        try {
            $body = Validator::make($request->all(), [
                'id_post'=>'required',
                'id_user'=> 'required'
            ]);
            $like = Like::create($request->all());
            $nLike = Post::find($request->id_post)->likes()->count();
            return response(['msg'=>'Correcto', 'like'=>$like, 'nLike'=>$nLike],201);
        }catch (\Exception $exception){
            return response($exception, 500);
        }
    }
    public function dislike(Request $request){
        $body = Validator::make($request->all(), [
            'id_post'=>'required',
            'id_user'=> 'required'
        ]);
        $dislike = Like::where('id_user', '=', $request['id_user'])
            ->where('id_post', '=', $request['id_post'])->delete();
        $nDislike = Post::find($request->id_post)->likes()->count();
        return response(['msg'=>'Correcto', 'dislike'=>$dislike,'nDislike'=>$nDislike]);
    }
    public function allFollows($id){
        return User::find($id)->followers()->get();
    }
   public function getPostsPerfil($id){
        return Post::where('id_user','=',$id)->with('user','likes','comments.user')->get();
}
public function newPost(Request $request){
        $body= $request->all();
        return Post::create($body);

}

} // Cierre final
