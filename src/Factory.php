<?php

namespace BCLib\DBTracker;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\RedisCache;

class Factory
{
    /**
     * @param $redis_host
     * @param $redis_port
     * @param $redis_db
     * @return \Doctrine\Common\Cache\Cache
     */
    public static function buildCache($redis_host, $redis_port, $redis_db)
    {
        try {
            $cache = self::buildRedisCache($redis_host, $redis_port, $redis_db);
        } catch (\RedisException $e) {
            $cache = new FilesystemCache(__DIR__ . '/../storage');
            error_log("RedisException: " . $e->getMessage());
        }
        return $cache;
    }

    private static function buildRedisCache($host, $port, $db)
    {
        $redis = new \Redis();
        $redis->connect($host, $port);
        $redis->select($db);
        $cache = new RedisCache();
        $cache->setRedis($redis);
        return $cache;
    }
}