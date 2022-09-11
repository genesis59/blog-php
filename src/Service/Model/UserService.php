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
}
