<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;

class CustomsOfficer
{
    const ACCESS_ADMIN_AUTHORIZED_ROLE = ['role_admin', 'role_editor'];
    const ACCESS_ADMIN_USERS_AUTHORIZED_ROLE = ['role_admin'];

    public function isAuthorized(User $user): bool
    {
        if (in_array($user->getRoleUsers(), self::ACCESS_ADMIN_AUTHORIZED_ROLE)) {
            return true;
        }
        return false;
    }

    public function isAdmin(User $user): bool
    {
        if (in_array($user->getRoleUsers(), self::ACCESS_ADMIN_USERS_AUTHORIZED_ROLE)) {
            return true;
        }
        return false;
    }
}
