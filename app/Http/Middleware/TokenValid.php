<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Admin::where("id", $request->admin_id)->first(['token']);
        if (!isset($token)) {
            return response()->json([
                "error" => true,
                "authorize" => true,
                "message" => "User doesn't exists"
            ]);
        } else {
            if (
                $token->token == $request->bearerToken()
            ) {
                return $next($request);
            } else {
                // return "here";
                return response()->json([
                    "error" => true,
                    "authorize" => false,
                    "message" => "Unauthorized,Invalid Token"
                ]);
            }
        }

        // return $next($request);
    }
}
