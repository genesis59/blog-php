<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Model\Entity\User;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Model\UserService;
use App\Service\Security\SecurityService;
use App\Service\Validator;
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
        private readonly Session $session,
        private readonly Validator $validator,
        private readonly UserService $userService
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

    public function signin(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirect($this->env["URL_DOMAIN"]);
        }
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            if ($this->validator->formRegisterIsValid($request)) {
                if ($this->userService->newUser($request)) {
                    return $this->redirect($this->env["URL_DOMAIN"]);
                }
            }
        }
        return new Response($this->view->render([
            'template' => 'signin',
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => 'inscription',
            'form' => [
                'pseudo' => $request->request()->get('pseudo') ?? "",
                'email' => $request->request()->get('email') ?? "",
                'confidentialite' => $request->request()->get('confidentialite') ?? "",
            ]
        ]));
    }
}
