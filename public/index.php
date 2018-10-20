<?php
// report errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../functions.php';

define('ROOT', __DIR__ . '/../');
define('CONTROLLER_PATH', '\App\Controller\\');
define('PUBLIC_ROOT', ROOT . 'public/');
define('APP_NAME', '4Screens');
define('APP_ROOT', ROOT . 'app/');
define('APP_PROTOCOL', stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://');
define('APP_URL', APP_PROTOCOL . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])) . '/');
define('APP_CONFIG_FILE', ROOT . 'config.php');

// View Config
define('VIEW_PATH', '../app/View/');
define('DEFAULT_HEADER_PATH', 'layout/header');
define('HTMLENTITIES_FLAGS', ENT_QUOTES);
define('HTMLENTITIES_ENCODING', 'UTF-8');
define('HTMLENTITIES_DOUBLE_ENCODE', false);

// main app
$app = require_once __DIR__ . '/../sloki/app.php';

// start application
$app->run();