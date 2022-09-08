<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Frontoffice\ArticleController;
use App\Controller\Frontoffice\HomeController;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Model\ArticleService;
use App\View\View;

final class Router
{
    private readonly Database $database;
    private readonly View $view;
    private readonly Session $session;
    private readonly Validator $validator;
    private readonly MailerService $mailerService;
    private readonly ArticleService $articleService;
    private readonly ArticleRepository $articleRepository;
    private readonly UserRepository $userRepository;
    private readonly HomeController $homeController;
    private readonly ArticleController $articleController;


    /**
     * @param Request $request
     * @param array<string,string> $env
     */
    public function __construct(private readonly Request $request, private readonly array $env)
    {
        $this->database = new Database($this->env['MYSQL_DSN'], $this->env['MYSQL_USER'], $this->env['MYSQL_PASSWORD']);
        $this->session = new Session();
        $this->view = new View($this->session);
        $this->validator = new Validator($this->session);
        $this->articleRepository = new ArticleRepository($this->database);
        $this->userRepository = new UserRepository($this->database);
        $this->mailerService = new MailerService($this->env['MAIL_HOST'], (int)$this->env['MAIL_PORT'], $this->session, $this->view);
        $this->articleService = new ArticleService($this->articleRepository, $this->userRepository, $this->session);
        $this->articleController = new ArticleController($this->articleService, $this->view, $this->env, $this->session);
        $this->homeController = new HomeController($this->articleService, $this->view, $this->validator, $this->env);
    }

    public function run(): Response
    {
        // TODO tableau des noms de route
        $pathInfo = $this->request->server()->get('PATH_INFO');
        $requestMethod = $this->request->server()->get("REQUEST_METHOD");
        if ($pathInfo === null) {
            $pathInfo = "/home";
        }
        if ($pathInfo === "/home") {
            return $this->homeController->index($this->request, $this->mailerService);
        }
        if ($pathInfo === '/article') {
            if (!$this->request->query()->has('numero') || $this->request->query()->get('numero') === "") {
                $this->session->addFlashes("info", "L'article demandé n'existe pas");
                return $this->articleController->articles(1);
            }
            return $this->articleController->article((int) $this->request->query()->get('numero'));
        }
        if ($pathInfo === '/articles') {
            $page = 1;
            if ($this->request->query()->has('page') && $this->request->query()->get('page') !== "") {
                $page = (int)$this->request->query()->get('page');
            }
            return $this->articleController->articles($page);
        }
        if ($pathInfo === '/admin') {
            return new Response("<h1>Bienvenue dans l'administration 😉</h1>", 200);
        }
        return new Response("Error 404 - cette page n'existe pas<br><a href='index.php?action=accueil'>Aller Ici</a>", 404, [
            "content_type" => "text/html",
            "charset" => "UTF-8"
        ]);
    }
}
