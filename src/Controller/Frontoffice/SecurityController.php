<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Model\Entity\User;
use App\Model\Repository\UserRepository;
use App\Service\CsrfValidator;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Validator\FormValidator;
use App\View\View;

class SecurityController
{
    use ControllerTrait;

    private function checkLoginIsValid(Request $request): bool
    {
        $email = null;
        $password = null;
        if ($request->request()->has("email")) {
            $email = $request->request()->get("email");
        }
        if ($request->request()->has("password")) {
            $password = $request->request()->get("password");
        }
        if ($email && $password) {
            /** @var User $user */
            $user = $this->userRepository->findOneBy(['email' => $email]);

            if (password_verify($password, $user->getPass())) {
                $this->session->addFlashes("success", "Votre authentification a réussi.");
                $this->session->set("user", $user);
                return true;
            }
        }
        $this->session->addFlashes("danger", "Email ou mot de passe invalide.");
        return false;
    }

    /**
     * @param array<string,string> $env
     */
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly array $env,
        private readonly View $view,
        private readonly Session $session,
        private readonly FormValidator $validator,
        private readonly CsrfValidator $csrfValidator
    ) {
    }

    public function login(Request $request): Response
    {
        $user = $this->getUser() ?? null;
        if ($user) {
            $this->session->addFlashes('info', 'Vous êtes déjà connecté');
            $this->redirect($this->env['URL_DOMAIN']);
        }
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            $this->csrfValidator->validateCsrfToken($request);
            $check = $this->checkLoginIsValid($request);
            if ($check) {
                $this->redirect($this->env['URL_DOMAIN']);
            }

            $this->redirect($this->env['URL_DOMAIN'] . "login");
        }
        return new Response($this->view->render([
            'template' => 'frontoffice/pages/login',
            'header_title' => 'Se connecter à mon compte'
        ]));
    }

    public function logout(): void
    {
        $this->session->remove('user');
        $this->redirect($this->env['URL_DOMAIN']);
    }

    public function register(Request $request): Response
    {
        if ($this->getUser()) {
            $this->redirect($this->env["URL_DOMAIN"]);
        }
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            $this->csrfValidator->validateCsrfToken($request);
            if ($this->validator->formRegisterIsValid($request)) {
                try {
                    $user = new User();
                    $user->setCreatedAt(new \DateTime());
                    $user->setUpdatedAt(new \DateTime());
                    $user->setRoleUsers("role_user");
                    $user->setPseudo($request->request()->get('pseudo'));
                    $user->setEmail($request->request()->get('email'));
                    $user->setPass(password_hash($request->request()->get('password'), PASSWORD_ARGON2I));
                    $this->userRepository->create($user);
                    $this->session->set("user", $user);
                    $this->session->addFlashes("success", "Bravo, votre inscription est un succès");
                    $this->redirect($this->env["URL_DOMAIN"]);
                } catch (\Exception $e) {
                    $this->session->addFlashes("danger", "Désolé impossible de vous inscrire pour le moment.");
                }
            }
        }
        return new Response($this->view->render([
            'template' => 'frontoffice/pages/signin',
            'header_title' => 'inscription',
            'form' => [
                'pseudo' => $request->request()->get('pseudo') ?? "",
                'email' => $request->request()->get('email') ?? "",
                'confidentialite' => $request->request()->get('confidentialite') ?? "",
            ]
        ]));
    }
}
