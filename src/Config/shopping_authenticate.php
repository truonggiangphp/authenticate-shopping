<?php

use Webikevn\AuthenticateShopping\Models\TblMpSession;

return [
    'monoris_cookie_name' => 'monoris9',
    'monoris_header_name' => 'auth-monoris',
    'domain' => env('WEBIKE_DOMAIN', 'www.webike.net'),
    'enable' => true,
    'auth_driver' => 'web',
    'monoris_authenticate_type' => TblMpSession::MONORIS_COOKIE,
    'allow_debug_cookie' => env('ALLOW_NOT_AUTHENTICATE', false),
    'cookie_debug' => env('COOKIE_DEBUG', ''),
    'session_expiry' => env('WEBIKE_SESSION_EXPIRY', 30), //Session expiry in minutes
    'is_enable_login_session' => false,
    'is_enable_store_session' => false,
    'webike_api_verify_session' => env('WEBIKE_API_VERIFY_SESSION', '')
];
