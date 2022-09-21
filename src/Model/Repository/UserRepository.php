<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\User;

/**
 * @template T of object
 * @extends BaseRepository<T>
 */
class UserRepository extends BaseRepository
{
    /**
     * @var class-string<T>
     */
    protected string $class = User::class;

    /**
     * @param T $entity
     * @return bool
     */
    public function create(object $entity): bool
    {
        if (!$entity instanceof User || $this->findOneBy(['pseudo' => $entity->getPseudo()]) || $this->findOneBy(['email' => $entity->getEmail()])) {
            return false;
        }
        $sql = 'INSERT INTO ' . $this->getClassName() . '(pseudo,email,pass,created_at,updated_at) VALUES (:pseudo,:email,:pass,NOW(),NOW())';
        $this->database->prepare($sql);
        $this->database->execute(['pseudo' => $entity->getPseudo(), 'email' => $entity->getEmail(), 'pass' => $entity->getPass()]);
        return true;
    }

    /**
     * @param T $entity
     * @return bool
     */
    public function update(object $entity): bool
    {
        if (!$entity instanceof User) {
            return false;
        } else {
            if (!$this->findOneBy(['id' => $entity->getId()])) {
                return false;
            }
            /** @var User $testPseudo */
            $testPseudo = $this->findOneBy(['pseudo' => $entity->getPseudo()]);
            if ($testPseudo !== null) {
                if ($testPseudo->getId() !== $entity->getId()) {
                    return false;
                }
            }
            /** @var User $testEmail */
            $testEmail = $this->findOneBy(['email' => $entity->getEmail()]);
            if ($testEmail !== null) {
                if ($testEmail->getId() !== $entity->getId()) {
                    return false;
                }
            }
        }
        $sql = 'UPDATE ' . $this->getClassName() . ' SET pseudo = :pseudo, email = :email, pass = :pass, updated_at = NOW(), role_users = :role WHERE id = :id';
        $this->database->prepare($sql);
        $this->database->execute(['id' => $entity->getId(), 'pseudo' => $entity->getPseudo(), 'email' => $entity->getEmail(), 'pass' => $entity->getPass(), 'role' => $entity->getRoleUsers()]);
        return true;
    }
}
