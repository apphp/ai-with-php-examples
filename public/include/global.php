<?php

// Local
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('OS_APP_DIRECTORY', '');
define('APP_MODE', 'local');
define('APP_PATH', '/var/www/');
define('APP_SEO_LINKS', true);
define('APP_URL', 'http://localhost:8088/');
define('APP_URL_DIR', '');
define('GOOGLE_CID', '');
define('OPEN_AI_KEY', '');

// Prod
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
//define('APP_MODE', 'production');
//define("APP_PATH", '');
//define("APP_SEO_LINKS", true);
//define("APP_URL", "");
//define("APP_URL_DIR", 'examples/');
//define("GOOGLE_CID", '');
//define('OPEN_AI_KEY', '');
