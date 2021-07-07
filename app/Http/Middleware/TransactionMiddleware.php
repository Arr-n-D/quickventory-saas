<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Support\Arr;

class TransactionMiddleware
{
    public $transactionMethods = [
        'POST',
        'PATCH',
        'PUT',
        'DELETE'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Arr::has($this->transactionMethods, $request->method())) {
            DB::beginTransaction();
        }
        return $next($request);
    }

    public function terminate($request, $response)
    {
        DB::commit();
    }
}