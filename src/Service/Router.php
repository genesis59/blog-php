<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\ArticleController;
use App\Controller\CommentController;
use App\Controller\Frontoffice\HomeController;
use App\Controller\SecurityController;
use App\Controller\UserController;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Validator\FormValidator;
use App\View\View;

final class Router
{
    private readonly Database $database;
    private readonly Hydrator $hydrator;
    private readonly View $view;
    private readonly Session $session;
    private readonly FormValidator $formValidator;
    private readonly ArticleRepository $articleRepository;
    private readonly UserRepository $userRepository;
    private readonly CommentRepository $commentRepository;
    private readonly MailerService $mailerService;
    private readonly HomeController $homeController;
    private readonly ArticleController $articleController;
    private readonly SecurityController $securityController;
    private readonly Paginator $paginator;
    private readonly CommentController $commentController;
    private readonly UserController $userController;


    /**
     * @param Request $request
     * @param array<string,string> $env
     */
    public function __construct(private readonly Request $request, private readonly array $env)
    {
        $this->database = new Database($this->env['MYSQL_DSN'], $this->env['MYSQL_USER'], $this->env['MYSQL_PASSWORD']);
        $this->hydrator = new Hydrator($this->database);
        $this->session = new Session();
        $this->paginator = new Paginator();
        $this->view = new View($this->session, $this->env);
        $this->articleRepository = new ArticleRepository($this->database, $this->hydrator);
        $this->userRepository = new UserRepository($this->database, $this->hydrator);
        $this->commentRepository = new CommentRepository($this->database, $this->hydrator);
        $this->mailerService = new MailerService($this->env['MAIL_HOST'], (int)$this->env['MAIL_PORT'], $this->session, $this->view);
        $this->formValidator = new FormValidator($this->session, $this->userRepository);
        $this->articleController = new ArticleController($this->articleRepository, $this->userRepository, $this->commentRepository, $this->view, $this->env, $this->session, $this->formValidator, $this->paginator);
        $this->homeController = new HomeController($this->view, $this->formValidator, $this->session, $this->paginator, $this->articleRepository);
        $this->securityController = new SecurityController($this->view, $this->env, $this->session, $this->formValidator, $this->userRepository);
        $this->commentController = new CommentController($this->view, $this->session, $this->env, $this->paginator, $this->commentRepository);
        $this->userController = new UserController($this->view, $this->session, $this->env, $this->userRepository, $this->articleRepository, $this->paginator);
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
            return $this->articleController->article($this->request);
        }
        if ($pathInfo === '/articles') {
            return $this->articleController->articles($this->request);
        }

        if ($pathInfo === '/login') {
            return $this->securityController->login($this->request);
        }

        if ($pathInfo === '/logout') {
            $this->securityController->logout();
        }

        if ($pathInfo === '/signin') {
            return $this->securityController->register($this->request);
        }

        if ($pathInfo === '/privacy') {
            return $this->homeController->privacy();
        }

        /** Route BACK OFFICE */

        // vérification de l'autorisation de l'utilisateur

        if (str_starts_with($pathInfo, '/admin')) {
            if (!$this->securityController->isAuthorized()) {
                $this->session->addFlashes("danger", "Vous n'êtes pas autorisé à accéder à cette page");
                return $this->homeController->index($this->request, $this->mailerService);
            }
        }

        if ($pathInfo === '/admin') {
            return $this->articleController->articles($this->request, false);
        }

        if ($pathInfo === '/admin/article/new') {
            return $this->articleController->new($this->request);
        }

        if ($pathInfo === '/admin/article/edit') {
            return $this->articleController->edit($this->request);
        }

        if ($pathInfo === '/admin/comments') {
            return $this->commentController->comments($this->request);
        }

        if ($pathInfo === '/admin/users') {
            return $this->userController->users($this->request);
        }

        return new Response($this->view->render([
            'template' => 'frontoffice/pages/errors/404',
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => 'Page introuvable',
        ]));
    }
}
