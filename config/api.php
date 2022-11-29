<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Versions
    |--------------------------------------------------------------------------
    */
   
    'key' => env('API_KEY', null),
    
    'ios' => [
        'stable_version' => env('IOS_STABLE_VERSION', '0.0.1'),
        'minimum_version' => env('IOS_MINIMUM_VERSION', '0.0.1'),
    ],

    'android' => [
        'stable_version' => env('ANDROID_STABLE_VERSION', '0.0.1'),
        'minimum_version' => env('ANDROID_MINIMUM_VERSION', '0.0.1'),
    ],
];