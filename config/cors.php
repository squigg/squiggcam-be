<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials'    => false,
    'allowedOrigins'         => explode(',', env('APP_HOSTS', '')),
    'allowedOriginsPatterns' => [],
    'allowedHeaders'         => ['*'],
    'allowedMethods'         => ['*'],
    'exposedHeaders'         => [],
    'maxAge'                 => 0,

];
