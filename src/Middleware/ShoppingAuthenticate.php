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

        $isCookie = config('shopping_authenticate.monoris_authenticate_type') === TblSession::MONORIS_COOKIE;

        if ($isCookie) {
            $isDebug = config('shopping_authenticate.allow_debug_cookie');
            if ($isDebug) {
                $monoris = Cookie::get(config('shopping_authenticate.cookie_debug'));
            } else {
                $monoris = Cookie::get(config('shopping_authenticate.monoris_cookie_name'));
            }
        } else {
            $monoris = $request->header(config('shopping_authenticate.monoris_header_name'));
        }


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
