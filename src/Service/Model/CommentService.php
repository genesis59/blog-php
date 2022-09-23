<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Entity\Article;
use App\Model\Entity\Comment;
use App\Model\Entity\User;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Session\Session;
use App\Service\Pagination\PaginationTrait;

class CommentService
{
    use PaginationTrait;

    private function hydrateUser(Comment $comment): Comment
    {
        $user = $this->userRepository->find($comment->getUser()->getId());
        if ($user instanceof User) {
            $comment->setUser($user);
        }
        return $comment;
    }

    /**
     * @param array<Comment> $comments
     * @return array<Comment>
     */
    private function hydrateUserCommentList(array $comments): array
    {
        foreach ($comments as $comment) {
            $this->hydrateUser($comment);
        }
        return $comments;
    }

    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly Session $session,
        private readonly UserRepository $userRepository
    ) {
    }

    public function addNewComment(Article $article, User $user, string $comment): void
    {
        $newComment = new Comment();
        $newComment->setCreatedAt(new \DateTime());
        $newComment->setIsActive(false);
        $newComment->setUser($user);
        $newComment->setArticle($article);
        $newComment->setContent($comment);
        $success = $this->commentRepository->create($newComment);
        if ($success) {
            $this->session->addFlashes('success', 'Merci pour votre commentaire. Nous le traiterons dans les plus brefs délais');
        } else {
            $this->session->addFlashes('danger', 'Une problème est survenu le commentaire ne peut être soumis.');
        }
    }

    /**
     * @param Article $article
     * @return Comment[]|null
     */
    public function getAllComment(Article $article): ?array
    {
        /** @var array<Comment> $comments */
        $comments = $this->commentRepository->findBy(["id_article" => $article->getId()]);
        if ($comments) {
            return $this->hydrateUserCommentList($comments);
        }
        return null;
    }

    /**
     * @param array<string,string> $order
     * @return Comment[]|null
     */
    public function getSomeHydratedCommentsPaginate(Article $article, int $limit, int $pageData, array $order = ["id" => "DESC"]): ?array
    {
        $nbPageMax = (int)ceil($this->commentRepository->count() / $limit);
        $currentPage = $this->getCurrentPage($pageData, $nbPageMax);

        /** @var array<int,Comment> $comments */
        $comments = $this->commentRepository->findBy(['id_article' => $article->getId(), 'is_active' => 1], $order, $limit, $limit * ($currentPage - 1));

        if ($comments) {
            return $this->hydrateUserCommentList($comments);
        }
        return null;
    }

    public function getTotalRows(Article $article = null): int
    {
        $criteria = [];
        if ($article !== null) {
            $criteria = ['id_article' => $article->getId()];
        }
        return $this->commentRepository->count($criteria);
    }
}