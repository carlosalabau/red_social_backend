<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Likes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Posts::orderBy('id','desc')->with('user','likes','coments')->get();
        return response($posts, 201);
    }
    public function like(Request $request){
        try {
            $body = Validator::make($request->all(), [
                'id_post'=>'required',
                'id_user'=> 'required'
            ]);
            $like = Likes::create($request->all());
            $nLike = Posts::find($request->id_post)->likes()->count();
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
        $dislike = Likes::where('id_user', '=', $request['id_user'])
            ->where('id_post', '=', $request['id_post'])->delete();
        $nDislike = Posts::find($request->id_post)->likes()->count();
        return response(['msg'=>'Correcto', 'dislike'=>$dislike,'nDislike'=>$nDislike]);
    }
}
