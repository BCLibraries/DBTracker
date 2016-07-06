<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BCLib\DBTracker\DatabaseStore;
use Slim\Slim;

$config = require __DIR__ . '/../config.php';

$app = new Slim();

$store = \BCLib\DBTracker\Factory::buildStore($config);

$app->get(
    '/.*',
    function () use ($store, $app) {
        $app->response->headers->set('Content-Type', 'application/json');
        $callback = $app->request->get('callback');
        $json = $store->get($callback);
        $app->response->setBody($json);
    }
);

$app->run();
