<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use JWTAuth; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\User;
class AuthController extends Controller
{
    public function __construct() {
        $this->middleware(['jwt.verify','cors'], ['except' => [ "registerUser", "loginUser", "logoutUser" ]]);
    } 

    public function loginUser(LoginRequest $request){
        try {
            if (isset($request->validator) && $request->validator->fails()) { 
                $data = array( 'status' => 'error', 'message' => 'Los datos proporcionados no son válidos.', 'errors' => $request->validator->errors(), 'code' => 400 ); 
            }
            else{
                if (! $token = JWTAuth::attempt($request->json)) { 
                    $data = array( "status" => 'error', 'code' => 401, "message" => 'Credenciales Inválidos.' );
                }
                else{ 
                    if(auth()->user()->active == 0){
                        $data = array( "status" => 'error', 'code' => 401, 'message' => 'Usuario no válido' ); 
                    }
                    else{
                        $user = auth()->user();
                        $user->token = $token;
                        $user->token_type = 'bearer';  
                        $user->expire_in = auth()->factory()->getTTL() * 60;
                        $data = array( 
                            "status"        => true, 
                            'code'          => 200,   
                            'user'          => $user,
                        );
                    }
                    
                } 
            }
        } catch (\Throwable $th) {
            $data = array( 'status' => 'error', 'message' => 'Hay un error en el sistema',  'code' => 400 ); 
        }
        return response()->json($data, $data["code"]);
    }

    public function registerUser(RegisterRequest $request)
    {
        try {
            if (isset($request->validator) && $request->validator->fails()) { 
                 
                $data = array( 
                    'status' => 'error', 
                    'message' => 'Los datos proporcionados no son válidos.', 
                    'errors' => $request->validator->messages(), 
                    'code' => 400 
                ); 
            }
            else{ 
                $pwd = Hash::make( $request->json['password'] );
                $user = new User();
                $user->name     = $request->json['name'];
                $user->lastname = $request->json['lastname'];
                $user->email    = $request->json['email'];
                $user->password = $pwd; 
                $user->role     = "admin";
                $user->active   = 1;

                if( !empty($request->json["photo"]) ) { 
                    $img = preg_replace('/^data:image\/\w+;base64,/', '', $request->json["photo"]);
                    $img = str_replace(' ','+',$img);
                    $type = explode(';', $request->json["photo"])[0];
                    $type = explode('/', $type)[1];
                    $nameImage = time().'.'.$type;
                    if(!empty($type)){ 
                        Storage::disk('local')->put('public/images/profiles/'.$nameImage,base64_decode($img));
                        $user->photo = '/storage/images/profiles/'.$nameImage;   
                    }
                }  
                $user->save(); 
                $data = array( 
                    "status"        => 'success', 
                    'code'          => 200, 
                    'message'       => "Usuario registrado", 
                );
            }
        }catch(Exception $exception)
        {
            $data = array( 'status' => 'error', 'message' => 'Error',  'code' => 400 ); 
        } 
        return response()->json($data, $data["code"]);
    }
    public function logoutUser(Request $request){   
        $auth = false;
        if( auth()->check() ) {  
            $auth = auth()->logout(); 
        }  
        $data = array(
            "status"    => 'success',
            "code"      => 200,  
            "message"   => 'Haz cerrado sesión con éxito.',
            "auth"      => auth()->check()
        );
        return response()->json($data , $data["code"]);  
    }

    public function profileUser(){
        $user = auth()->user();
        $data = array(
            "status"    => 'success',
            "code"      => 200,  
            "data"   => $user,
            "authCheck"      => auth()->check(), 
        );
        return response()->json($data , $data["code"]); 
    }

}
