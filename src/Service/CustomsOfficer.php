<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use App\Service\Http\Session\Session;

class CustomsOfficer
{
    public function __construct(private readonly Session $session)
    {
    }

    public function secureAccessRoute(string $pathInfo): bool
    {
        if ($pathInfo && str_starts_with($pathInfo, '/admin')) {
            if (!$this->session->get('user') || !$this->isAuthorized($this->session->get('user'))) {
                $this->session->addFlashes("danger", "Vous n'êtes pas autorisé à accéder à cette page");
                return false;
            }
        }
        if ($pathInfo === "/admin/users" && $this->session->get('user') !== null && ! $this->isAdmin($this->session->get('user'))) {
            $this->session->addFlashes("danger", "Vous n'êtes pas autorisé à accéder à cette page");
            return false;
        }
        return true;
    }

    public function isAuthorized(User|null $user): bool
    {

        if (!$user) {
            return false;
        }
        if (in_array($user->getRoleUsers(), ['role_admin', 'role_editor'])) {
            return true;
        }
        return false;
    }

    public function isAdmin(User|null $user): bool
    {
        if ($user && in_array($user->getRoleUsers(), ['role_admin'])) {
            return true;
        }
        return false;
    }
}
