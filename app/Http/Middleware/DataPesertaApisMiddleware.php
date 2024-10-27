<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseJSON;
use App\Models\DataPesertaAuthKey;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DataPesertaApisMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $key = $request->key;
            if (DataPesertaAuthKey::find($key) === null) {
                return ResponseJSON::unauthorized("Anda tidak memiliki akses");
            }
        } catch (\Throwable $th) {
            Log::error('DataPesertaApis : ' . $th);
            return ResponseJSON::unauthorized("Anda tidak memiliki akses");
        }
        return $next($request);
    }
}
