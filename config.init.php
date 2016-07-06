<?php

$config = new stdClass();

// LibGuides configuration
$config->libguides_api_key = 'LIBGUIDES_API_KEY_HERE';
$config->libguides_site_id = 'LIBGUIDES_SITE_ID_HERE';

// Redis configuration
$config->redis_host = 'localhost';
$config->redis_port = 6379;
$config->redis_db = 12;

$config->base_dir = __DIR__;

$config->proxy_url = 'proxy.bc.edu';

return $config;