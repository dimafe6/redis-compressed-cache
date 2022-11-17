<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cache key prefix
    |--------------------------------------------------------------------------
    |
    | You may prefix every cache key to avoid collisions. By default, uses default laravel cache prefix.
    |
    */

    'prefix' => config('cache.prefix'),

    /*
    |--------------------------------------------------------------------------
    | Redis database connection
    |--------------------------------------------------------------------------
    |
    | Redis connection name that described on the database.php.
    |
    */

    'connection' => env('REDIS_COMPRESSED_CACHE_CONNECTION', 'cache'),

    /*
    |--------------------------------------------------------------------------
    | Redis database lock connection
    |--------------------------------------------------------------------------
    |
    | Redis lock connection name that described on the database.php.
    |
    */

    'lock_connection' => env('REDIS_COMPRESSED_CACHE_LOCK_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Compression enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable compression.
    |
    */

    'enabled' => env('REDIS_COMPRESSED_CACHE_ENABLED', true),
];
