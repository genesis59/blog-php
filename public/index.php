<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\Service\Container;
use App\Service\Environment;
use App\Service\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


if ((new Environment())->get("APP_ENV") === 'dev') {
    $whoops = new Run();
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();
}
$container = new Container($_GET, $_POST, $_FILES, $_SERVER);

$router = $container->get(Router::class);
$response = $router->run();
$response->send();
