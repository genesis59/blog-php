<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\Service\Http\Request;
use App\Service\Environment;
use App\Service\Http\Session\Session;
use App\Service\MailerService;
use App\Service\Router;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

$env = (new Environment())->getEnv();

if ($env['APP_ENV'] === 'dev') {
    $whoops = new Run();
    $whoops->pushHandler(new PrettyPageHandler());
    $whoops->register();
}

$request = new Request($_GET, $_POST, $_FILES, $_SERVER);
$router = new Router($request,$env);
$response = $router->run();
$response->send();