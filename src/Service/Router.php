<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Request;
use App\Service\Http\Response;
use PHPStan\Type\CallableType;
use ReflectionClass;

final class Router
{
    /**
     * @var array<string,mixed>
     */
    private array $dataHandler = [
        "Database" => [
            "name" => "App\Service\Database",
            "attributes" => [
                "services" => [],
                "dataHandler" => [],
                "environmentVariable" => [
                    "MYSQL_DSN",
                    "MYSQL_USER",
                    "MYSQL_PASSWORD"
                ]
            ]
        ],
        "Hydrator" => [
            "name" => "App\Service\Hydrator",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Database"
                ],
                "environmentVariable" => []
            ]
        ],
        "ArticleRepository" => [
            "name" => "App\Model\Repository\ArticleRepository",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Database",
                    "Hydrator"
                ],
                "environmentVariable" => []
            ]
        ],
        "UserRepository" => [
            "name" => "App\Model\Repository\UserRepository",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Database",
                    "Hydrator"
                ],
                "environmentVariable" => []
            ]
        ],
        "CommentRepository" => [
            "name" => "App\Model\Repository\CommentRepository",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Database",
                    "Hydrator"
                ],
                "environmentVariable" => []
            ]
        ]
    ];
    /**
     * @var array<string,mixed>
     */
    private array $services = [
        "Session" => [
            "name" => "App\Service\Http\Session\Session",
            "attributes" => [
                "services" => [],
                "dataHandler" => [],
                "environmentVariable" => []
            ]
        ],
        "CsrfValidator" => [
            "name" => "App\Service\CsrfValidator",
            "attributes" => [
                "services" => [
                    "Session"
                ],
                "dataHandler" => [],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "View" => [
            "name" => "App\View\View",
            "attributes" => [
                "services" => [
                    "Session",
                    "CsrfValidator"
                ],
                "dataHandler" => [],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "FormValidator" => [
            "name" => "App\Service\Validator\FormValidator",
            "attributes" => [
                "services" => [
                    "Session"
                ],
                "dataHandler" => [
                    "UserRepository"
                ],
                "environmentVariable" => []
            ]
        ],
        "CustomsOfficer" => [
            "name" => "App\Service\CustomsOfficer",
            "attributes" => [
                "services" => [
                    "Session"
                ],
                "dataHandler" => [],
                "environmentVariable" => []
            ]
        ],
        "MailerService" => [
            "name" => "App\Service\MailerService",
            "attributes" => [
                "services" => [
                    "Session",
                    "View"
                ],
                "dataHandler" => [],
                "environmentVariable" => [
                    "MAIL_HOST",
                    "MAIL_PORT"
                ]
            ]
        ],
        "Paginator" => [
            "name" => "App\Service\Paginator",
            "attributes" => [
                "services" => [],
                "dataHandler" => [],
                "environmentVariable" => []
            ]
        ],
        "Slugify" => [
            "name" => "App\Service\Slugify",
            "attributes" => [
                "services" => [],
                "dataHandler" => [],
                "environmentVariable" => []
            ]
        ],
    ];
    /**
     * @var array<string,mixed>
     */
    private array $controllers = [
        "HomeController" => [
            "name" => "App\Controller\Frontoffice\HomeController",
            "attributes" => [
                "services" => [
                    "View",
                    "FormValidator",
                    "Session",
                    "Paginator",
                    "CsrfValidator"
                ],
                "dataHandler" => [
                    "ArticleRepository"
                ],
                "environmentVariable" => []
            ]
        ],
        "ArticleController" => [
            "name" => "App\Controller\Frontoffice\ArticleController",
            "attributes" => [
                "services" => [
                    "View",
                    "Session",
                    "FormValidator",
                    "Paginator",
                    "CsrfValidator"
                ],
                "dataHandler" => [
                    "ArticleRepository",
                    "CommentRepository"
                ],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "SecurityController" => [
            "name" => "App\Controller\Frontoffice\SecurityController",
            "attributes" => [
                "services" => [
                    "View",
                    "Session",
                    "FormValidator",
                    "CsrfValidator"
                ],
                "dataHandler" => [
                    "UserRepository"
                ],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "AdminArticleController" => [
            "name" => "App\Controller\Backoffice\AdminArticleController",
            "attributes" => [
                "services" => [
                    "View",
                    "Session",
                    "FormValidator",
                    "Paginator",
                    "Slugify",
                    "CsrfValidator"
                ],
                "dataHandler" => [
                    "ArticleRepository",
                    "UserRepository",
                ],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "AdminCommentController" => [
            "name" => "App\Controller\Backoffice\AdminCommentController",
            "attributes" => [
                "services" => [
                    "View",
                    "Session",
                    "Paginator",
                    "CsrfValidator"
                ],
                "dataHandler" => [
                    "CommentRepository"
                ],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "AdminUserController" => [
            "name" => "App\Controller\Backoffice\AdminUserController",
            "attributes" => [
                "services" => [
                    "View",
                    "Session",
                    "Paginator",
                    "CsrfValidator"
                ],
                "dataHandler" => [
                    "UserRepository",
                    "ArticleRepository"
                ],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ]
    ];
    /**
     * @var array<string,mixed>
     */
    private array $routes = [
        "home" => [
            "startUri" => "/home",
            "paramUri" => [],
            "controller" => "HomeController",
            "method" => "index",
            "attributes" => [
                "services" => [
                    "MailerService"
                ],
                "dataHandler" => [
                    "Request"
                ]
            ],
        ],
        "privacy" => [
            "startUri" => "/privacy",
            "paramUri" => [],
            "controller" => "HomeController",
            "method" => "register",
            "attributes" => [
                "services" => [],
                "dataHandler" => []
            ],
        ],
        "articles" => [
            "startUri" => "/articles",
            "paramUri" => [],
            "controller" => "ArticleController",
            "method" => "articles",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "article" => [
            "startUri" => "/article",
            "paramUri" => ["slug"],
            "controller" => "ArticleController",
            "method" => "article",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "login" => [
            "startUri" => "/login",
            "paramUri" => [],
            "controller" => "SecurityController",
            "method" => "login",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ]
            ],
        ],
        "logout" => [
            "startUri" => "/logout",
            "paramUri" => [],
            "controller" => "SecurityController",
            "method" => "logout",
            "attributes" => [
                "services" => [],
                "dataHandler" => []
            ],
        ],
        "signin" => [
            "startUri" => "/signin",
            "paramUri" => [],
            "controller" => "SecurityController",
            "method" => "register",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "admin" => [
            "startUri" => "/admin",
            "paramUri" => [],
            "controller" => "AdminArticleController",
            "method" => "index",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "admin_article_new" => [
            "startUri" => "/admin/article/new",
            "paramUri" => [],
            "controller" => "AdminArticleController",
            "method" => "new",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "admin_article_edit" => [
            "startUri" => "/admin/article/edit",
            "paramUri" => ["slug"],
            "controller" => "AdminArticleController",
            "method" => "edit",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "admin_comments" => [
            "startUri" => "/admin/comments",
            "paramUri" => [],
            "controller" => "AdminCommentController",
            "method" => "comments",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ],
        "admin_users" => [
            "startUri" => "/admin/users",
            "paramUri" => [],
            "controller" => "AdminUserController",
            "method" => "users",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
            ]
        ]
    ];

    /**
     * @var array<string,mixed>
     */
    private array $attributesDataHandler = [];
    /**
     * @var array<string,mixed>
     */
    private array $attributesServices = [];
    /**
     * @var array<string,mixed>
     */
    private array $attributesControllers = [];

    /**
     * @var string|null $nameRoute
     */
    private string|null $nameRoute;

    /**
     * @var array<mixed,string>
     */
    private array $paramsRouteList;

    /**
     * @param Request $request
     * @param array<string,string> $env
     * @param array<string,mixed> $dataInstance
     * @param array<string,mixed> $dataInstanceList
     * @return void
     */
    private function instantiate(Request $request, array $env, array $dataInstance, array &$dataInstanceList): void
    {
        foreach ($dataInstance as $key => $value) {
            $nameInstance = $value["name"];
            $attributes = [];
            // Instantiation dataHandler
            foreach ($value["attributes"]["dataHandler"] as $attribute) {
                if ($attribute === "Request") {
                    $attributes[] = $request;
                    continue;
                }
                $attributes[] = $this->attributesDataHandler[$attribute];
            }
            // Instantiation environments variables
            foreach ($value["attributes"]["environmentVariable"] as $attribute) {
                if ($attribute === "Environment") {
                    $attributes[] = $env;
                    continue;
                }
                $attributes[] = $env[$attribute];
            }
            // Instantiation services
            foreach ($value["attributes"]["services"] as $attribute) {
                $attributes[] = $this->attributesServices[$attribute];
            }
            $dataInstanceList[$key] = $this->createInstance($nameInstance, $attributes);
        }
    }

    /**
     * @param string $className
     * @param array<int,mixed> $arguments
     * @return false|mixed
     */
    private function createInstance(string $className, array $arguments = array()): mixed
    {
        if (class_exists($className)) {
            return call_user_func_array(
                array(
                    new ReflectionClass($className), 'newInstance'),
                $arguments
            );
        }
        return false;
    }

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
                    $numberOfParamsExpected = count($route["paramUri"]);
                    $paramsRouteListTemp = explode("/", substr(substr($pathInfo, strlen($route["startUri"])), 1));
                    if (count($paramsRouteListTemp) === $numberOfParamsExpected) {
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
            if ($attribute === "Request") {
                $attributes[] = $this->request;
                continue;
            }
            $attributes[] = $this->attributesDataHandler[$attribute];
        }
        foreach ($this->routes[$this->nameRoute]["attributes"]["services"] as $attribute) {
            $attributes[] = $this->attributesServices[$attribute];
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

        // typage de la variable $callbackController qui annule l'erreur suivante de PHPStan
        // Parameter #1 $callback of function call_user_func_array expects callable(): mixed, array{mixed, mixed} given.
        /** @var mixed $callbackController */
        $callbackController = array($this->attributesControllers[$controller], $method);
        return call_user_func_array($callbackController, $attributes);
    }


    /**
     * @param Request $request
     * @param array<string,string> $env
     */
    public function __construct(private readonly Request $request, private readonly array $env)
    {
        // Attributes must be in this order into instances (dataHandler,environment,services)
        $this->instantiate($this->request, $this->env, $this->dataHandler, $this->attributesDataHandler);
        $this->instantiate($this->request, $this->env, $this->services, $this->attributesServices);
        $this->instantiate($this->request, $this->env, $this->controllers, $this->attributesControllers);
    }


    public function run(): Response
    {
        $pathInfo = $this->request->server()->get('PATH_INFO') ? $this->request->server()->get('PATH_INFO') : null;
        if (!$pathInfo) {
            $pathInfo = "/home";
        }
        // vérification des autorisations de l'utilisateur
        if (!$this->attributesServices["CustomsOfficer"]->secureAccessRoute($pathInfo)) {
            return $this->attributesControllers["HomeController"]->index($this->request, $this->attributesServices["MailerService"]);
        }

        $this->getNameRoute($pathInfo);

        if (!$this->nameRoute) {
            return new Response($this->attributesServices["View"]->render([
                'template' => 'frontoffice/pages/errors/404',
                'url_domain' => $this->env["URL_DOMAIN"],
                'header_title' => 'Page introuvable',
            ]));
        }
        return $this->launchControllerRoute();
    }
}
