<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Frontoffice\HomeController;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\View\View;
use Symfony\Component\Yaml\Yaml;

final class Router
{
    /**
     * @var array<string,mixed>
     */
    private array $routes;

    /**
     * @var string|null $nameRoute
     */
    private string|null $nameRoute;

    /**
     * @var array<mixed,string>
     */
    private array $paramsRouteList;

    private function getNameRoute(string $pathInfo): void
    {
        $this->nameRoute = null;
        $this->paramsRouteList = [];
        foreach ($this->routes as $key => $route) {
            if (str_starts_with($pathInfo, $route["startUri"])) {
                if ($pathInfo === $route["startUri"]) {
                    $this->nameRoute = $key;
                    break;
                }
                if ($route["paramUri"] > 0) {
                    // $route["paramUri"] liste des clé eventuelles
                    // $paramsListTemp liste des paramètres éventuelles
                    $paramsRouteListTemp = explode("/", substr(substr($pathInfo, strlen($route["startUri"])), 1));
                    if (count($paramsRouteListTemp) === count($route["paramUri"])) {
                        $this->nameRoute = $key;
                        for ($i = 0; $i < count($paramsRouteListTemp); $i++) {
                            $this->paramsRouteList[$route["paramUri"][$i]] = $paramsRouteListTemp[0];
                        }
                        break;
                    }
                }
            }
        }
    }

    /**
     * @return array<mixed>
     */
    private function getAttributesRoute(): array
    {
        $attributes = [];
        foreach ($this->routes[$this->nameRoute]["attributes"]["dataHandler"] as $attribute) {
            if ($attribute === Request::class) {
                $attributes[] = $this->request;
                continue;
            }
            $attributes[] = $this->container->get($attribute);
        }
        foreach ($this->routes[$this->nameRoute]["attributes"]["services"] as $attribute) {
            $attributes[] = $this->container->get($attribute);
        }
        foreach ($this->paramsRouteList as $param) {
            $attributes[] = $param;
        }
        return $attributes;
    }

    private function launchControllerRoute(): Response
    {
        // Préparation du controller, de la method et des attributs à passer à la methode du controller
        $controller = $this->routes[$this->nameRoute]["controller"];
        $method = $this->routes[$this->nameRoute]["method"];
        $attributes = $this->getAttributesRoute();

        /** @var mixed $callbackController */
        $callbackController = array($this->container->get($controller), $method);
        return call_user_func_array($callbackController, $attributes);
    }

    /**
     * @param Request $request
     * @param Container $container
     * @param Environment $environment
     */
    public function __construct(private readonly Request $request, private readonly Container $container, private readonly Environment $environment)
    {
        $this->routes = Yaml::parseFile($this->environment->get("CONFIG_ROUTES"));
    }

    public function run(): Response
    {
        $pathInfo = $this->request->server()->get('PATH_INFO') ? $this->request->server()->get('PATH_INFO') : null;
        if (!$pathInfo) {
            $pathInfo = "/home";
        }
        // vérification des autorisations de l'utilisateur
        /** @var CustomsOfficer $customersOfficer */
        $customersOfficer = $this->container->get(CustomsOfficer::class);
        if (!$customersOfficer->secureAccessRoute($pathInfo)) {
            /** @var HomeController $homeController */
            $homeController = $this->container->get(HomeController::class);
            /** @var MailerService $mailerService */
            $mailerService = $this->container->get(MailerService::class);
            return $homeController->index($this->request, $mailerService);
        }
        $this->getNameRoute($pathInfo);

        if (!$this->nameRoute) {
            /** @var View $view */
            $view = $this->container->get("View");
            return new Response($view->render([
                'template' => 'frontoffice/pages/errors/404',
                'url_domain' => $this->environment->get("URL_DOMAIN"),
                'header_title' => 'Page introuvable',
            ]));
        }
        return $this->launchControllerRoute();
    }
}
