<?php

return [

    'defaults' => [
        'guard' => 'kasir',
        'passwords' => 'kasirs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'kasir' => [
            'driver' => 'session',
            'provider' => 'kasirs', // pakai provider kasirs di bawah
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'kasirs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Kasir::class, // model yang benar
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Configuration
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'kasirs' => [
            'provider' => 'kasirs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
