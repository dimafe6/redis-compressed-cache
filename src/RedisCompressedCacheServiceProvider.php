<?php

namespace Dimafe6\RedisCompressedCache;

use Illuminate\Support\Facades\Cache;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Class RedisCompressedCacheServiceProvider
 *
 * @category PHP
 * @package  Dimafe6\RedisCompressedCache
 * @author   Dmytro Feshchenko <dimafe2000@gmail.com>
 */
class RedisCompressedCacheServiceProvider extends PackageServiceProvider
{
    /**
     * @param Package $package
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('redis-compressed-cache')
            ->hasConfigFile();
    }

    /**
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    public function packageBooted()
    {
        Cache::extend('redis-compressed', function ($app) {
            $store = new RedisStore(
                $app['redis'],
                config('redis-compressed-cache.prefix'),
                config('redis-compressed-cache.connection')
            );

            return Cache::repository(
                $store
                    ->setLockConnection(config('redis-compressed-cache.lock_connection'))
                    ->setUseCompression(config('redis-compressed-cache.enabled'))
            );
        });
    }
}
