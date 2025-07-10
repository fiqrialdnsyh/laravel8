<?php

return [

    'defaults' => [
        'guard' => 'web', // default tetap web (users)
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        'poscos' => [ // guard tambahan untuk user_poscos
            'driver' => 'session',
            'provider' => 'user_poscos',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'user_poscos' => [
            'driver' => 'eloquent',
            'model' => App\Models\UserPoscos::class, // pastikan model ini ada
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'user_poscos' => [ // kalau perlu reset password juga
            'provider' => 'user_poscos',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

    'poscos' => [
            'driver' => 'session',
            'provider' => 'user_poscos',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

    'user_poscos' => [
            'driver' => 'eloquent',
            'model' => App\Models\UserPoscos::class,
        ],
    ],
];
