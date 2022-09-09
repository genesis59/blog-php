<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Entity\Article;
use App\Model\Entity\Comment;
use App\Model\Entity\User;
use App\Model\Repository\CommentRepository;
use App\Service\Http\Session\Session;

class CommentService extends EntityService
{
    public function __construct(private readonly CommentRepository $commentRepository, private readonly Session $session)
    {
        parent::__construct($this->commentRepository);
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
            $this->session->addFlashes('success', 'Votre commentaire à bien été soumis.');
        } else {
            $this->session->addFlashes('danger', 'Une problème est survenu le commentaire ne peut être soumis.');
        }
    }
}
