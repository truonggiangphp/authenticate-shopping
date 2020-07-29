<?php

use Webikevn\AuthenticateShopping\Models\TblSession;

return [
    'monoris_cookie_name' => 'monoris9',
    'monoris_header_name' => 'auth-monoris',
    'domain' => env('WEBIKE_DOMAIN', 'www.webike.net'),
    'enable' => true,
    'auth_driver' => 'web',
    'monoris_authenticate_type' => TblSession::MONORIS_COOKIE,
    'allow_debug_cookie' => env('ALLOW_NOT_AUTHENTICATE', false),
    'cookie_debug' => env('COOKIE_DEBUG', ''),
];