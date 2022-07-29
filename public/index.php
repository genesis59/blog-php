<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
require_once '../env.php';

use App\Service\Http\Request;


if (APP_ENV === 'dev') {
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}

$request = new Request($_GET, $_POST, $_FILES, $_SERVER);

