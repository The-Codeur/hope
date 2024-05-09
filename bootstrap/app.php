<?php

use App\App;
use App\Http\Core\HttpKernel;

define('DS', DIRECTORY_SEPARATOR);

define('BASE_PATH', dirname(__DIR__).DS);

require_once BASE_PATH.'vendor'.DS.'autoload.php';

$app = HttpKernel::bootstrap(new App)->getApplication();
