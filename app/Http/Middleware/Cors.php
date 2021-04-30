<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Origin: null');

        

        $headers = [
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin',
            'Access-Control-Expose-Headers'=> 'X-Mashery-Error-Code, X-Mashery-Responder',
            'Access-Control-Max-Age'=> '3628800'
        ];
        if($request->getMethod() == "OPTIONS") {
            return Response::make('OK', 200, $headers);
        }
        

        $response = $next($request);
        foreach($headers as $key => $value)
            $response->header($key, $value);
        return $response;
    }
}
