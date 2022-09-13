<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Security\SecurityService;
use App\View\View;

class SecurityController
{
    use ControllerTrait;

    /**
     * @param array<string,string> $env
     */
    public function __construct(
        private readonly View $view,
        private readonly array $env,
        private readonly SecurityService $securityService,
        private readonly Session $session
    ) {
    }

    public function login(Request $request): Response
    {
        $user = $this->getUser() ?? null;
        if ($user) {
            $this->session->addFlashes('info', 'Vous êtes déjà connecté');
            return $this->redirect($this->env['URL_DOMAIN']);
        }
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            $check = $this->securityService->checkLoginIsValid($request);
            if ($check) {
                return $this->redirect($this->env['URL_DOMAIN']);
            }

            return $this->redirect($this->env['URL_DOMAIN'] . "login");
        }
        return new Response($this->view->render([
            'template' => 'login',
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => 'Se connecter à mon compte',
            'user' => $user
        ]));
    }

    public function logout(): Response
    {
        $this->session->remove('user');
        return $this->redirect($this->env['URL_DOMAIN']);
    }

    public function signin(): Response
    {
        return new Response($this->view->render([
            'template' => 'signin',
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => 'inscription'
        ]));
    }
}
