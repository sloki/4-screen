<?php

// Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// main app
$app = require_once __DIR__.'/../sloki/app.php';


// start application
$app->run();