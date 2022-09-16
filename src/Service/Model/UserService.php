<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Entity\User;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Session\Session;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Session $session
    ) {
    }

    public function getOne(int $id): ?User
    {
        $user = $this->userRepository->find($id);
        if ($user instanceof User) {
            return $user;
        }
        return null;
    }

    /**
     * @param array<string,string> $criteria
     * @return User|null
     */
    public function getOneBy(array $criteria): ?User
    {
        $user = $this->userRepository->findOneBy($criteria);
        if ($user instanceof User) {
            return $user;
        }
        return null;
    }

    public function newUser(Request $request): bool
    {
        $user = new User();
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());
        $user->setRoleUsers("role_user");
        $user->setPseudo($request->request()->get('pseudo'));
        $user->setEmail($request->request()->get('email'));
        $user->setPass(password_hash($request->request()->get('password'), PASSWORD_ARGON2I));

        try {
            $this->userRepository->create($user);
            $this->session->set("user", $user);
            $this->session->addFlashes("success", "Bravo, votre inscription est un succès");
            return true;
        } catch (\Exception $e) {
            $this->session->addFlashes("danger", "Désolé impossible de vous inscrire pour le moment.");
        }
        return false;
    }
}
