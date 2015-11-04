<?php

use Api\Rest\Application;

require_once 'error.php';
require_once 'middleware.php';

/**
 * @var Application $app
 */
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
