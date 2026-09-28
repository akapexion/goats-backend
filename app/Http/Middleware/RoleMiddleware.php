<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        if ($user->status === 'inactive') {
            return response()->json([
                'status'  => false,
                'message' => 'Your account has been deactivated. Please contact support.',
            ], 403);
        }

        if (! in_array($user->role, $roles)) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized. Required role: ' . implode(', ', $roles),
            ], 403);
        }

        return $next($request);
    }
}