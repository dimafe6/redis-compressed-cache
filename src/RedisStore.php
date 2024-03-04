<?php

namespace Dimafe6\RedisCompressedCache;

use Illuminate\Cache\RedisStore as IlluminateRedisStore;

/**
 * Class RedisStore. Compress value before store to Redis
 *
 * @category PHP
 * @package  App\Cache
 * @author   Dmytro Feshchenko <dimafe2000@gmail.com>
 */
class RedisStore extends IlluminateRedisStore
{
    /**
     * Zlib first byte of header.
     */
    public const ZLIB_HEADER = '78';

    /** @var bool $useCompression */
    protected bool $useCompression = true;

    /**
     * Get whether compression is enabled.
     *
     * @return bool
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    public function getUseCompression(): bool
    {
        return $this->useCompression;
    }

    /**
     * Enable or disable compression.
     *
     * @param bool $useCompression
     * @return RedisStore
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    public function setUseCompression(bool $useCompression)
    {
        $this->useCompression = $useCompression;

        return $this;
    }

    /**
     * @param $value
     * @return bool
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    private function isNeedCompression($value): bool
    {
        return $this->useCompression && !(is_numeric($value) && !in_array($value, [INF, -INF]) && !is_nan($value));
    }

    /**
     * @param $value
     * @return bool
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    private function isCompressed($value): bool
    {
        return bin2hex(mb_strcut($value, 0, 1)) === self::ZLIB_HEADER;
    }

    /**
     * Serialize the value.
     *
     * @param mixed $value
     * @return mixed
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    protected function serialize($value)
    {
        $value = parent::serialize($value);

        return $this->isNeedCompression($value) ? gzcompress(
            $value,
            config('redis-compressed-cache.compression_level')
        ) : $value;
    }

    /**
     * Unserialize the value
     *
     * @param mixed $value
     * @return mixed
     * @author Dmytro Feshchenko <dimafe2000@gmail.com>
     */
    protected function unserialize($value)
    {
        if (!is_numeric($value) && is_string($value)) {
            return unserialize($this->isCompressed($value) ? gzuncompress($value) : $value);
        }

        return $value;
    }
}
