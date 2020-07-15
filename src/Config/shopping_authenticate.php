<?php

use Webikevn\AuthenticateShopping\Models\TblSession;

return [
    'monoris_cookie_name' => 'monoris9',
    'monoris_header_name' => 'auth-monoris',
    'domain' => env('WEBIKE_DOMAIN', 'www.webike.net'),
    'enable' => true,
    'auth_driver' => 'web',
    'monoris_authenticate_type' => TblSession::MONORIS_COOKIE
];