<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = $request->json()->all();
        if (User::where(["email" => $data["email"]])
            ->orWhere(["name" => $data["name"]])
            ->first()) {
            return response()->json(["error"=>"user exist"]);
        }
        return $next($request);
    }
}
