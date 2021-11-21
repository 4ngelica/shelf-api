<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class AcceptJsonMiddleware
{
    public function verifyHeader($request, Closure $next)
    {
      if (!$request->isMethod('get')) return $next($request);


      $acceptHeader = $request->header('Accept');
      if ($acceptHeader != 'application/json') {
          return response()->json(['error'], 406);
      }

      return $next($request);
    }
}
