<?php

require_once realpath('../application/Config.php');

require_once realpath('../application/Loader.php');

$config = new \application\Config();

$loader = new application\Loader($config);

$loader->load();

$container = new application\Container($config);

$app = $container->make('application\App');

$app->appRun();