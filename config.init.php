<?php

$redis_host = 'localhost';
$redis_port = 6379;
$redis_db = 12;

$config = new stdClass();
$config->libguides_api_key = 'LIBGUIDES_API_KEY_HERE';
$config->libguides_site_id = 'LIBGUIDES_SITE_ID_HERE';
$config->cache = build_cache($redis_host, $redis_port, $redis_db);

function build_cache($host, $port, $db)
{
    $redis = new Redis();
    $redis->connect($host, $port);
    $redis->select($db);
    $cache = new \Doctrine\Common\Cache\RedisCache();
    $cache->setRedis($redis);
    return $cache;
}

return $config;