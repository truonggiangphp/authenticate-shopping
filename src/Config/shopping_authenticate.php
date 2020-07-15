<?php

use Webikevn\AuthenticateShopping\Models\TblSession;

return [
    'monoris_cookie_name' => 'monoris9',
    'domain' => env('WEBIKE_DOMAIN', 'www.webike.net'),
    'enable' => true,
    'auth_driver' => 'api',
    'monoris_authenticate_type' => TblSession::MONORIS_COOKIE
];