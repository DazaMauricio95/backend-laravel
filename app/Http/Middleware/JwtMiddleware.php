<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception; 
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    { 
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Throwable $th) {
            if ($th instanceof TokenInvalidException){  
                $data = array(  "status" => 'Unauthorized', 'code' =>  401,  "message" => 'El token no es válido' );
            }else if ($th instanceof TokenExpiredException) {   
                $data = array(  "status" => 'Unauthorized', 'code' => 401,  "message" =>  'El token no se puede actualizar, inicie sesión nuevamente' );
                    
            }else{ 
                $data = array(  "status" => 'Unauthorized', 'code' => 401,  "message" =>  'Token de autorización expirado o no se encontró, no se realizó está acción.' );
            }
            return response()->json($data, $data['code']);
        }
    }
}
