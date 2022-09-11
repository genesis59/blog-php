<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use App\Service\Http\RedirectResponse;
use App\Service\Http\Response;

trait ControllerTrait
{
    public function getUser(): ?User
    {
        if ($user = $this->session->get('user')) {
            if ($user instanceof User) {
                return $user;
            }
        }
        return null;
    }

    public function redirect(string $url): Response
    {
        return new RedirectResponse($this->env['URL_DOMAIN']);
    }
}
