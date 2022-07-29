<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Enum\Role;
use DateTime;

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
    private string $password;

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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }




}