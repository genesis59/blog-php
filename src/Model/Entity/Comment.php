<?php

declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use DateTime;
use Exception;

class Comment
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var DateTime
     */
    private DateTime $createdAt;

    /**
     * @var bool|int
     */
    private bool|int $isActive;

    /**
     * @var User
     */
    private User $user;

    /**
     * @var Article
     */
    private Article $article;

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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
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
     * @return bool|int
     */
    public function isActive(): bool|int
    {
        return $this->isActive;
    }

    /**
     * @param bool|int $isActive
     * @return void
     */
    public function setIsActive(bool|int $isActive): void
    {
        $value = $isActive;
        if (is_int($isActive)) {
            if ($isActive === 1) {
                $value = true;
            } else {
                $value = false;
            }
        }
        $this->isActive = $value;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article): void
    {
        $this->article = $article;
    }
}
