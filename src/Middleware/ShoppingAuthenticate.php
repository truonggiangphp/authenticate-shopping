<?php

namespace Webikevn\AuthenticateShopping\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Webikevn\AuthenticateShopping\Models\TblSession;
use Webikevn\AuthenticateShopping\Services\Monoris;

class ShoppingAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = \Auth::guard(config('shopping_authenticate.auth_driver'));

        $monoris = Monoris::getMonoris($request);
        if (!$monoris) {
            return $this->response($request);
        }
        $credentials = [
            with(new TblSession)->getTable() . '.session_id_a' => $monoris,
        ];
        $isAttempt = $auth->attempt($credentials) ?: false;
        if (!$isAttempt) {
            return $this->response($request);
        }

        return $next($request);
    }


    /**
     * @param $request
     */
    private function response($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect(config('shopping_authenticate.domain') . '?nextpage=' . $request->fullUrl());
        }
    }
}
