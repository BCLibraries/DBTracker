<?php

use BCLib\DBTracker\DatabaseStore;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config.php';

$cache = \BCLib\DBTracker\Factory::buildCache($config->redis_host, $config->redis_port, $config->redis_db);
$store = new DatabaseStore($cache, $config->libguides_site_id, $config->libguides_api_key, $config->proxy_url);
$store->refresh();