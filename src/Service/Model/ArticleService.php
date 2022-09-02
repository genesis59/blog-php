<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;

class ArticleService
{
    /**
     * @param Article $article
     * @return Article
     */
    private function hydrateOneUserArticle(Article $article): Article
    {
        /** @var User $user */
        $user = $this->userRepository->find($article->getUser()->getId());
        $article->setUser($user);
        return $article;
    }

    /**
     * @param Article|array<Article> $value
     * @return Article|array<Article>
     */
    private function hydrateOneOrAllUserArticle(Article|array $value): Article|array
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                $this->hydrateOneUserArticle($item);
            }
        } else {
            $this->hydrateOneUserArticle($value);
        }
        return $value;
    }

    public function __construct(private readonly ArticleRepository $articleRepository, private readonly UserRepository $userRepository,)
    {
    }

    /**
     * @return array<Article>
     */
    public function getAllArticles(): array
    {
        /** @var array<int,Article> $articles */
        $articles = $this->articleRepository->findAll();
        $this->hydrateOneOrAllUserArticle($articles);
        return $articles;
    }

    /**
     * @return array<Article>
     */
    public function getSomeLastArticles(int $nbArticle): array
    {
        /** @var array<int,Article> $articles */
        $articles = $this->articleRepository->findBy([], ["created_at" => "DESC"], $nbArticle);
        $this->hydrateOneOrAllUserArticle($articles);
        return $articles;
    }
}
