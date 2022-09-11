<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use App\Service\Model\UserService;
use App\Service\Validator;

class SecurityService
{
    const FORBIDDEN_ROLE = ['role_anonyme'];
    public function __construct(private readonly UserService $userService, private readonly Validator $validator, private readonly Session $session)
    {
    }
    public function checkLoginIsValid(Request $request): bool
    {
        $email = "";
        $password = "";
        $emailFormatIsValid = false;
        $passwordFormatIsValid = false;
        if ($request->request()->has("email")) {
            $email = $request->request()->get("email");
            $emailFormatIsValid = $this->validator->inputEmailIsValid($email);
        }
        if ($request->request()->has("password")) {
            $password = $request->request()->get("password");
            $passwordFormatIsValid = $this->validator->inputTextIsValid('password', $password, 8);
        }
        if ($passwordFormatIsValid && $emailFormatIsValid) {
            $user = $this->userService->getOneBy(['email' => $email]);
            if (!$user || in_array($user->getRoleUsers(), self::FORBIDDEN_ROLE)) {
                $this->session->addFlashes("danger", "Email ou mot de passe invalide.");
                return false;
            }
            if (password_verify($password, $user->getPass())) {
                $this->session->addFlashes("success", "Le connexion est un succés");
                $this->session->set("user", $user);
                return true;
            }
        }
        $this->session->addFlashes("danger", "Email ou mot de passe invalide.");
        return false;
    }
}
