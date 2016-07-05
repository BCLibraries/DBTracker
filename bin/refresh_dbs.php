<?php

use BCLib\DBTracker\DatabaseStore;

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config.php';

$store = new DatabaseStore($config->cache, $config->libguides_site_id, $config->libguides_api_key);
$store->refresh();