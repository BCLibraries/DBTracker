<?php

namespace BCLib\DBTracker;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\RedisCache;

class Factory
{
    /**
     * @param $config
     * @return DatabaseStore
     */
    public static function buildStore($config)
    {
        if ($config->use_redis) {
            $cache = self::buildRedisCache($config->redis_host, $config->redis_port, $config->redis_db);
        } else {
            $cache = new FilesystemCache(__DIR__ . '/../storage');
        }
        $store = new DatabaseStore($cache, $config->libguides_site_id, $config->libguides_api_key, $config->proxy_url);
        return $store;
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