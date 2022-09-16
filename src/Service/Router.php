<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Frontoffice\ArticleController;
use App\Controller\Frontoffice\HomeController;
use App\Controller\Frontoffice\SecurityController;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Model\ArticleService;
use App\Service\Model\CommentService;
use App\Service\Model\UserService;
use App\Service\Security\SecurityService;
use App\View\View;

final class Router
{
    private readonly Database $database;
    private readonly View $view;
    private readonly Session $session;
    private readonly Validator $validator;
    private readonly ArticleRepository $articleRepository;
    private readonly UserRepository $userRepository;
    private readonly CommentRepository $commentRepository;
    private readonly MailerService $mailerService;
    private readonly ArticleService $articleService;
    private readonly CommentService $commentService;
    private readonly UserService $userService;
    private readonly SecurityService $securityService;
    private readonly HomeController $homeController;
    private readonly ArticleController $articleController;
    private readonly SecurityController $userSecurityController;


    /**
     * @param Request $request
     * @param array<string,string> $env
     */
    public function __construct(private readonly Request $request, private readonly array $env)
    {
        $this->database = new Database($this->env['MYSQL_DSN'], $this->env['MYSQL_USER'], $this->env['MYSQL_PASSWORD']);
        $this->session = new Session();
        $this->view = new View($this->session);
        $this->articleRepository = new ArticleRepository($this->database);
        $this->userRepository = new UserRepository($this->database);
        $this->commentRepository = new CommentRepository($this->database);
        $this->mailerService = new MailerService($this->env['MAIL_HOST'], (int)$this->env['MAIL_PORT'], $this->session, $this->view);
        $this->articleService = new ArticleService($this->articleRepository, $this->userRepository, $this->session);
        $this->userService = new UserService($this->userRepository, $this->session);
        $this->commentService = new CommentService($this->commentRepository, $this->session, $this->userRepository);
        $this->securityService = new SecurityService($this->userService, $this->session);
        $this->validator = new Validator($this->session, $this->userService);
        $this->articleController = new ArticleController($this->articleService, $this->commentService, $this->view, $this->env, $this->session, $this->validator);
        $this->homeController = new HomeController($this->articleService, $this->view, $this->validator, $this->env, $this->session);
        $this->userSecurityController = new SecurityController($this->view, $this->env, $this->securityService, $this->session, $this->validator, $this->userService);
    }

    public function run(): Response
    {
        /** Route FRONT OFFICE */

        $pathInfo = $this->request->server()->get('PATH_INFO');
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
            $page = 1;
            if ($this->request->query()->has('page') && $this->request->query()->get('page') !== "") {
                $page = (int)$this->request->query()->get('page');
            }
            return $this->articleController->article((int)$this->request->query()->get('numero'), $this->request, $page);
        }
        if ($pathInfo === '/articles') {
            $page = 1;
            if ($this->request->query()->has('page') && $this->request->query()->get('page') !== "") {
                $page = (int)$this->request->query()->get('page');
            }
            return $this->articleController->articles($page);
        }

        if ($pathInfo === '/login') {
            return $this->userSecurityController->login($this->request);
        }

        if ($pathInfo === '/logout') {
            return $this->userSecurityController->logout();
        }

        if ($pathInfo === '/signin') {
            return $this->userSecurityController->signin($this->request);
        }

        if ($pathInfo === '/privacy') {
            return $this->homeController->privacy();
        }

        /** Route BACK OFFICE */

        if ($pathInfo === '/admin') {
            return new Response("<h1>Bienvenue dans l'administration 😉</h1>", 200);
        }

        return new Response($this->view->render([
            'template' => 'errors/404',
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => 'Page introuvable',
        ]));
    }
}
