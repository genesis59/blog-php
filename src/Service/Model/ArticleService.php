<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Session\Session;
use App\Service\Pagination\PaginationTrait;

class ArticleService
{
    use PaginationTrait;

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
     * @param array<Article> $value
     * @return array<Article>
     */
    private function hydrateAllUserInArticle(array $value): array
    {
        foreach ($value as $item) {
            if ($item instanceof Article) {
                $this->hydrateOneUserArticle($item);
            }
        }
        return $value;
    }

    public function __construct(private readonly ArticleRepository $articleRepository, private readonly UserRepository $userRepository, private readonly Session $session)
    {
    }

    public function getOne(int $id): ?Article
    {
        $article = $this->articleRepository->find($id);
        if ($article instanceof Article) {
            return $this->hydrateOneUserArticle($article);
        }
        $this->session->addFlashes("info", "L'article demandé n'existe pas");
        return null;
    }

    /**
     * @param array<string,string> $order
     * @return Article[]|null
     */
    public function getSomeHydratedArticlesPaginate(int $limit, int $pageData, array $order = ["id" => "DESC"]): ?array
    {
        $nbPageMax = (int)ceil($this->articleRepository->count() / $limit);
        $currentPage = $this->getCurrentPage($pageData, $nbPageMax);

        /** @var array<int,Article> $articles */
        $articles = $this->articleRepository->findBy([], $order, $limit, $limit * ($currentPage - 1));

        if ($articles) {
            return $this->hydrateAllUserInArticle($articles);
        }
        return null;
    }

    public function getPreviousArticleId(Article $article): ?int
    {
        $previousArticle = $this->articleRepository->getPreviousEntity($article);
        if ($previousArticle instanceof Article) {
            return $previousArticle->getId();
        }
        return null;
    }

    public function getNextArticleId(Article $article): ?int
    {
        $nextArticle = $this->articleRepository->getNextEntity($article);
        if ($nextArticle instanceof Article) {
            return $nextArticle->getId();
        }
        return null;
    }

    public function getTotalRows(): int
    {
        return $this->articleRepository->count();
    }
}
