<?php

require_once __DIR__ . '/../vendor/autoload.php';


use NexSite\App;

// Bootstrap the application
$app = App::getInstance();
$app->run();
