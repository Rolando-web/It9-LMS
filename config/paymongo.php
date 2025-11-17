<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PayMongo API Keys
    |--------------------------------------------------------------------------
    |
    | Here you may specify your PayMongo API keys for your application.
    | These keys are used to authenticate with PayMongo's API.
    |
    */

    'public_key' => env('PAYMONGO_PUBLIC_KEY', ''),
    
    'secret_key' => env('PAYMONGO_SECRET_KEY', env('PAYMONGO_SECRET', '')),

];
