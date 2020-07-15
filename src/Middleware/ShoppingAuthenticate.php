<?php

namespace Webikevn\AuthenticateShopping\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Webikevn\AuthenticateShopping\Models\TblSession;

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
        $monoris9 = $request->header(config('shopping_authenticate.monoris_cookie_name'));
        $credentials = [
            with(new TblSession)->getTable() . '.session_id_a' => $monoris9,
        ];
        $isAttempt = $auth->attempt($credentials) ?: false;

        if (!$isAttempt) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('https://' . config('shopping_authenticate.domain') . '/wbs/login.html?nextpage=' . $request->fullUrl());
            }
        }

        return $next($request);
    }
}