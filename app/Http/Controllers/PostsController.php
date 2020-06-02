<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Likes;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Posts::orderBy('id','desc')->with('user','likes')->get();
        return response($posts, 201);
    }
    public function like(Request $request){
        try {
            $body = Validator::make($request->all(), [
                'id_post'=>'required',
                'id_user'=> 'required'
            ]);
            $like = Likes::create($body);
            return response(['msg'=>'Correcto', 'like'=>$like],201);
        }catch (\Exception $exception){
            return response($exception, 500);
        }
    }
}
