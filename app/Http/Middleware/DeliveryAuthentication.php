<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeliveryAuthentication
{
    public function __construct()
    {
        Config::set('jwt.user', User::class);
        Config::set('auth.providers.users.model', User::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;

        try {
            //Access token from the request
            $token = JWTAuth::parseToken();
            //Try authenticating user
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {
            //Thrown if token has expired
            return $this->unauthorized('Your token has expired. Please, login again.');
        } catch (TokenInvalidException $e) {
            //Thrown if token invalid
            return $this->unauthorized('Your token is invalid. Please, login again.');
        } catch (JWTException $e) {
            //Thrown if token was not found in the request.
            return $this->unauthorized('Please, attach a Bearer Token to your request');
        }
//        }
        //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        if ($user) {
            return $next($request);
        }

        return $this->unauthorized();
    }

    private
    function unauthorized($message = null)
    {
        return response()->json([
            'success' => false,
            'errors' => $message,
            'status_code' => 1,
            'status_message' => 'failed',
            'message' => $message ? $message : 'You are unauthenticated ',
        ], 401);
    }
}

