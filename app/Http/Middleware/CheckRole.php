<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
  public function handle(Request $request, Closure $next, ...$roles)
  {
    $user = $request->user();

    //if (in_array($user->role, $roles)) {
      if (in_array($user->therole->permission, $roles)) {
      return $next($request);
    }

    return abort(403, 'Unauthorized action.');
  }
}
