<?php

namespace Webikevn\AuthenticateShopping\Services;

use Webikevn\AuthenticateShopping\Models\TblMpSession;
use Illuminate\Support\Facades\Cookie;

class Monoris
{
    /**
     * @param $request
     * @return string
     */
    public static function getMonoris($request)
    {
        $isCookie = config('shopping_authenticate.monoris_authenticate_type') === TblMpSession::MONORIS_COOKIE;
        $isDebug = config('shopping_authenticate.allow_debug_cookie');

        if ($isDebug) {
            return config('shopping_authenticate.cookie_debug');
        }

        if ($isCookie) {
            return Cookie::get(config('shopping_authenticate.monoris_cookie_name'));
        } else {
            return $request->header(config('shopping_authenticate.monoris_header_name'));
        }
    }
}