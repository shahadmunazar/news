<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        
        $user = Auth::user();
        $userRoles = $user->roles->pluck('name');
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required.'
            ], 401);
        }

        
        if (!$userRoles->contains($role)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have access to this resource.'
            ], 403);
        }

        // Continue to the next middleware or controller
        return $next($request);
    }
}
