<?php

// Define the base path.
define('BASE_PATH', dirname(dirname(__FILE__)));

require BASE_PATH . '/src/vendor/autoload.php';

ini_set('magic_quotes_runtime', 0);
date_default_timezone_set('UTC');

// Init the app.
$config = require BASE_PATH . '/config.php';
$app    = new \SlimGoodies\Slim($config);

// Register routes.
require BASE_PATH . '/src/app/routes.php';

// Run app
$app->run();
