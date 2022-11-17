# Laravel cache driver with compression.

This driver provides ability to compress and decompress Redis data.

## Installation

You can install the package via composer:

```bash
composer require dimafe6/redis-compressed-cache
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="redis-compressed-cache-config"
```

This is the contents of the published config file:

```php
return [
    'prefix'          => config('cache.prefix'),
    'connection'      => env('REDIS_COMPRESSED_CACHE_CONNECTION', 'cache'),
    'lock_connection' => env('REDIS_COMPRESSED_CACHE_LOCK_CONNECTION', 'default'),
    'enabled'         => env('REDIS_COMPRESSED_CACHE_ENABLED', true),
];
```

## Usage

Add the `redis-compressed` custom driver to the `redis` store config in `config/cache.php`:

```php
'redis' => [
    'driver'          => 'redis-compressed',
    'connection'      => 'cache',
    'lock_connection' => 'default',
]
```

Or create a new store:

```php
'redis-compressed' => [
    'driver'          => 'redis-compressed',
]
```

## Credits

- [Dmytro Feshchenko](https://github.com/dimafe6)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
