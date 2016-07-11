<?php

require_once __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config.php';

$store = \BCLib\DBTracker\Factory::buildDatabaseStore($config);
$store->refresh();