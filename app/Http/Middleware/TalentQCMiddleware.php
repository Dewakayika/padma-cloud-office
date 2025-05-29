<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TalentQCMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'talent_qc') {
            abort(403, 'Unauthorized. Talent QC access required.');
        }

        return $next($request);
    }
}