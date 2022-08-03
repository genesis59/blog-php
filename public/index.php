<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\Service\Http\Request;
use App\Service\Environment;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

new Environment();

if (Environment::$env['APP_ENV'] === 'dev') {
    $whoops = new Run();
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();
}

$request = new Request($_GET, $_POST, $_FILES, $_SERVER);
