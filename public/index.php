<?php

require_once '../vendor/autoload.php';

$app = new \Api\Rest\Application();
$app->get('/', function () use($app) {
    return $app->json([time()]);
});

require_once '../app/config/config.php';

$app->run();
