<?php

namespace BCLib\DBTracker;

use Doctrine\Common\Cache\RedisCache;

class Factory
{
    public static function buildCache($host, $port, $db)
    {
        $redis = new \Redis();
        $redis->connect($host, $port);
        $redis->select($db);
        $cache = new RedisCache();
        $cache->setRedis($redis);
        return $cache;
    }
}