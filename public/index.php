<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\Service\Http\Request;

const APP_ENV = 'dev';

if (APP_ENV === 'dev') {
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}

$request = new Request($_GET, $_POST, $_FILES, $_SERVER);

