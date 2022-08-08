<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Frontoffice\HomeController;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\View\View;

final class Router
{
    private readonly Database $database;
    private readonly View $view;
    private readonly Session $session;

    /**
     * @param Request $request
     * @param array<string,string> $env
     */
    public function __construct(private readonly Request $request, private readonly array $env)
    {
        $this->database = new Database($this->env['MYSQL_DSN'], $this->env['MYSQL_USER'], $this->env['MYSQL_PASSWORD']);
        $this->session = new Session();
        $this->view = new View($this->session);
    }

    public function run(): Response
    {
        $action = $this->request->query()->has('action') ? $this->request->query()->get('action') : 'accueil';

        if ($action === 'accueil') {
            $controller = new HomeController(new ArticleRepository($this->database), new UserRepository($this->database), $this->view);
            return $controller->index();
        } elseif ($action === 'contact') {
            $controller = new HomeController(new ArticleRepository($this->database), new UserRepository($this->database), $this->view);
            return $controller->contact($this->request);
        }
        return new Response("Error 404 - cette page n'existe pas<br><a href='index.php?action=accueil'>Aller Ici</a>", 404);
    }
}
