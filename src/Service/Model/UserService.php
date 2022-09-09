<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Entity\User;
use App\Model\Repository\UserRepository;

class UserService extends EntityService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        parent::__construct($this->userRepository);
    }

    public function getOne(int $id): ?User
    {
        $user = $this->userRepository->find($id);
        if ($user instanceof User) {
            return $user;
        }
        return null;
    }
}
