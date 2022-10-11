<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Request;
use App\Service\Http\Response;
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
        "TokenGenerator" => [
            "name" => "App\Service\TokenGenerator",
            "attributes" => [
                "services" => [
                    "Session"
                ],
                "dataHandler" => [],
                "environmentVariable" => []
            ]
        ],
        "View" => [
            "name" => "App\View\View",
            "attributes" => [
                "services" => [
                    "Session",
                    "TokenGenerator"
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
        "CustomOfficer" => [
            "name" => "App\Service\CustomOfficer",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Database",
                    "Hydrator"
                ],
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
                ],
                "dataHandler" => [
                    "ArticleRepository"
                ],
                "environmentVariable" => [
                    "Environment"
                ]
            ]
        ],
        "ArticleController" => [
            "name" => "App\Controller\Frontoffice\ArticleController",
            "attributes" => [
                "services" => [
                    "View",
                    "Session",
                    "FormValidator",
                    "Paginator"
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
                    "Slugify"
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
                    "Paginator"
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
                    "Paginator"
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
            "environmentVariable" => []
        ],
        "privacy" => [
            "controller" => "HomeController",
            "method" => "register",
            "attributes" => [
                "services" => [],
                "dataHandler" => []
            ],
            "environmentVariable" => []
        ],
        "articles" => [
            "controller" => "ArticleController",
            "method" => "articles",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
                "environmentVariable" => []
            ]
        ],
        "article" => [
            "controller" => "ArticleController",
            "method" => "article",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request",
                    "Slug"
                ],
                "environmentVariable" => []
            ]
        ],
        "login" => [
            "controller" => "SecurityController",
            "method" => "login",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ]
            ],
            "environmentVariable" => []
        ],
        "logout" => [
            "controller" => "SecurityController",
            "method" => "logout",
            "attributes" => [
                "services" => [],
                "dataHandler" => []
            ],
            "environmentVariable" => []
        ],
        "signin" => [
            "controller" => "SecurityController",
            "method" => "register",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
                "environmentVariable" => []
            ]
        ],
        "admin" => [
            "controller" => "AdminArticleController",
            "method" => "index",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
                "environmentVariable" => []
            ]
        ],
        "admin/article/new" => [
            "controller" => "AdminArticleController",
            "method" => "new",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
                "environmentVariable" => []
            ]
        ],
        "admin/article/edit" => [
            "controller" => "AdminArticleController",
            "method" => "edit",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request",
                    "Slug"
                ],
                "environmentVariable" => []
            ]
        ],
        "admin/comments" => [
            "controller" => "AdminCommentController",
            "method" => "comments",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
                "environmentVariable" => []
            ]
        ],
        "admin/users" => [
            "controller" => "AdminUserController",
            "method" => "users",
            "attributes" => [
                "services" => [],
                "dataHandler" => [
                    "Request"
                ],
                "environmentVariable" => []
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
    private function createInstance(string $className, array $arguments = array())
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
        //TODO PARAM TYPE SLUG
        // vérification de l'autorisation de l'utilisateur

//        if (str_starts_with($pathInfo, '/admin')) {
//            if ($this->session->get('user') !== null && !$this->customsOfficer->isAuthorized($this->session->get('user'))) {
//                $this->session->addFlashes("danger", "Vous n'êtes pas autorisé à accéder à cette page");
//                return $this->homeController->index($this->request, $this->mailerService);
//            }
//        }
//        if ($this->session->get('user') !== null && !$this->customsOfficer->isAdmin($this->session->get('user'))) {
//            $this->session->addFlashes("danger", "Vous n'êtes pas autorisé à accéder à cette page");
//            return $this->adminArticleController->index($this->request);
//        }
        /** Route FRONT OFFICE */

        $pathInfo = $this->request->server()->get('PATH_INFO') ? $this->request->server()->get('PATH_INFO') : null;
        //TODO PARAM TYPE SLUG
//        if(isset($pathInfo)){
//            var_dump(count(explode("/", $pathInfo)));
//            die();
//        }
        $nameRoute = "home";
        if ($pathInfo !== null) {
            $nameRoute = substr($this->request->server()->get('PATH_INFO'), 1);
        }
        if (explode("/", $nameRoute)[0] === "article") {
            $nameRoute = explode("/", $nameRoute)[0];
        }
        if (isset($pathInfo) && str_starts_with($pathInfo, '/admin/article/edit')) {
            $nameRoute = "admin/article/edit";
        }
        if (!isset($this->routes[$nameRoute])) {
            return new Response($this->services["View"]->render([
                'template' => 'frontoffice/pages/errors/404',
                'url_domain' => $this->env["URL_DOMAIN"],
                'header_title' => 'Page introuvable',
            ]));
        }
        $controller = $this->routes[$nameRoute]["controller"];
        $method = $this->routes[$nameRoute]["method"];
        $attributes = [];

        foreach ($this->routes[$nameRoute]["attributes"]["dataHandler"] as $attribute) {
            if ($attribute === "Request") {
                $attributes[] = $this->request;
                continue;
            }
            if ($attribute === "Slug") {
                if (str_starts_with($pathInfo, '/article/') || str_starts_with($pathInfo, '/admin/article/edit')) {
                    $pathInfoList = explode("/", $pathInfo);
                    $slug = $pathInfoList[count($pathInfoList) - 1];
                    $attributes[] = $slug;
                    continue;
                }
            }
            $attributes[] = $this->attributesDataHandler[$attribute];
        }
        foreach ($this->routes[$nameRoute]["attributes"]["services"] as $attribute) {
            $attributes[] = $this->attributesServices[$attribute];
        }
        return call_user_func_array(array($this->attributesControllers[$controller], $method), $attributes);
    }
}
