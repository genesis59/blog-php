<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\ControllerTrait;
use App\Service\Http\Request;
use App\Service\Http\Session\Session;

class CsrfValidator
{
    use ControllerTrait;

    /**
     * @param Session $session
     * @param Environment $environment
     */
    public function __construct(private readonly Session $session, private readonly Environment $environment)
    {
    }

    public function generateToken(): string
    {
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $this->session->set("token", $token);
        return $token;
    }

    public function validateCsrfToken(Request $request): bool
    {
        if ($this->session->get("token") !== $request->request()->get("token")) {
            $this->session->addFlashes("danger", "Désolé, impossible d'exécuter cette action pour le moment.");
            $this->redirect($this->environment->get("URL_DOMAIN"));
        }
        return true;
    }
}
