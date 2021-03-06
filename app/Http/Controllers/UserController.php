<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();

    }

    public function register(Request $request)
    {
        try {
            $valid = Validator::make($request->all(), [
                'nombre' => 'required',
                'apellidos' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:8|max:20',
                'edad' => 'required',
                'sexo' => 'required'
            ]);
            if ($valid->fails()) {
                $errores = $valid->errors();
                $msg = [];
                foreach ($errores->keys() as $donde) {
                    switch ($donde) {
                        case 'nombre':
                            $msg[] = 'El nombre es requerido';
                            break;
                        case 'apellidos':
                            $msg[] = 'El apellido es requerido';
                            break;
                        case 'email':
                            $msg[] = 'El email ya existe';
                            break;
                        case 'password':
                            $msg[] = 'El password debe tener como minimo 8 caracteres y 20 como maximo';
                            break;
                        case 'edad':
                            $msg[] = 'La edad es requerida';
                            break;
                        case 'sexo':
                            $msg[] = 'El campo sexo es requerido';
                            break;
                    }
                }
                return response()->json($msg, 400);
            } else {

                $user = new User();
                $user->nombre = $request->all()['nombre'];
                $user->apellidos = $request->all()['apellidos'];
                $user->email = $request->all()['email'];
                $user->password = Hash::make($request->password);
                $user->edad = $request->all()['edad'];
                $user->sexo = $request->all()['sexo'];
                $user->save();
                return response($user, 201);
            }
        } catch (\Exception $e) {
            return response([
                'message' => 'There was an error trying to register the user',
                'error' => $e
            ], 500);
        }
    }

    public function login(Request $request)
    {
         try {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Usuario o contraseña incorrectos'
            ], 400);
        }
        $user = Auth::user();//req.user
        $token = $user->createToken('authToken')->accessToken;
        $user->token = $token;
        return response([
            'user' => $user,
            'token' => $token
        ]);
         } catch (\Exception $e) {
              return response([
                  'message' => 'There was an error trying to login the user',
                  'error' => $e
              ], 500);
          }
    }

    public function logout()
    {
        try {
            // Auth::user()->token()->delete();
            Auth::user()->token()->revoke();
            return response([
                'message' => 'User successfully disconected.'
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'There was an error trying to login the user',
                'error' => $e
            ], 500);
        }
    }

    public function getUser()
    {
        return Auth::user();
    }

    public function search($letter)
    {
        $search = User::where('nombre', 'like', '%' . $letter . '%')->with('following')->get();
        return $search;
    }

    public function updateImages(Request $request)
    {
        try {
            $user = Auth::user();
            if($request->has('imagen')){
                $nombre = time() . "_" . request()->imagen->getClientOriginalName();
                request()->imagen->move('img', $nombre);
                $user->imagen = $nombre;
            }
            if($request->has('imagen_perfil')) {
                $nombre2 = time() . "_" . request()->imagen_perfil->getClientOriginalName();
                request()->imagen_perfil->move('img', $nombre2);
                $user->imagen_perfil = $nombre2;
            }
            $user->id = Auth::id();
            $user->save();
            return response(['msg' => 'correcto']);
        } catch (\Exception $e) {
            return response(['error' => $e], 500);
        }
    }

    public function follow(Request $request)
    {
        $user = Auth::user();
        $follow = DB::table('followers')->insert(['id_followed' => $request[0], 'id_follower' => $user->id]);
        return response(['msg'=>'Sois amigos','follow'=>$follow],200);
    }
    public function unfollow(Request $request)
    {
        try {
            $user = Auth::user();
            $unfollow = DB::table('followers')->where('id_follower', '=', $user->id)
                ->where('id_followed', '=', $request[0])->delete();
            return response(['msg' => 'Ya no sois amigos', 'unfollow' => $unfollow], 200);
        }catch (\Exception $e){
            return response(['msg'=>'Ha ocurrido un error', 500]);
        }
    }

}
