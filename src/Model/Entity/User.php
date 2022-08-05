<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\Role;
use DateTime;
use Exception;

class User
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $pseudo;

    /**
     * @var string
     */
    private string $roleUsers;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $pass;

    /**
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @var DateTime
     */
    private DateTime $updatedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getRoleUsers(): string
    {
        return $this->roleUsers;
    }

    /**
     * @param string $roleUsers
     */
    public function setRoleUsers(string $roleUsers): void
    {
        $this->roleUsers = $roleUsers;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|string $createdAt
     * @throws Exception
     */
    public function setCreatedAt(DateTime|string $createdAt): void
    {
        if (is_string($createdAt)) {
            $this->createdAt = new DateTime($createdAt);
        }
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|string $updatedAt
     * @throws Exception
     */
    public function setUpdatedAt(DateTime|string $updatedAt): void
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = new DateTime($updatedAt);
        }
    }
}
