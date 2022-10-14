<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Controller\ControllerTrait;
use App\Model\Entity\Comment;
use App\Model\Repository\CommentRepository;
use App\Service\CsrfValidator;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Paginator;
use App\View\View;

class AdminCommentController
{
    use ControllerTrait;

    const MAX_COMMENT_PER_PAGE = 5;

    /**
     * @param View $view
     * @param Session $session
     * @param array<string,string> $env
     * @param Paginator $paginator
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly array $env,
        private readonly View $view,
        private readonly Session $session,
        private readonly Paginator $paginator,
        private readonly CsrfValidator $csrfValidator
    ) {
    }

    public function comments(Request $request): Response
    {

        if ($request->server()->get("REQUEST_METHOD") === "POST" && $request->request()->has("typeAction")) {
            $this->csrfValidator->validateCsrfToken($request);
            /** @var Comment $comment */
            $comment = $this->commentRepository->find((int)$request->request()->get("id"));
            if ($comment == null) {
                $this->session->addFlashes("danger", "Désolé, impossible de réaliser cette action.");
            }
            if ($request->request()->get("typeAction") == "accept") {
                $comment->setIsActive(true);
                $this->commentRepository->update($comment);
                $this->session->addFlashes("success", "Le commentaire a été validé.");
            }
            if ($request->request()->get("typeAction") == "delete") {
                $this->commentRepository->delete($comment);
                $this->session->addFlashes("success", "Le commentaire a été supprimé.");
            }
            $this->redirect($this->env["URL_DOMAIN"] . "admin/comments");
        }

        // Récupération des données pour la pagination
        $pageData = $request->query()->has("page") ? (int)$request->query()->get("page") : 1;
        $maxPage = $this->paginator->getMaxPage($this->commentRepository->count(["is_active" => 0]), self::MAX_COMMENT_PER_PAGE);
        if (!$this->paginator->isExistingPage($pageData, $maxPage)) {
            $pageData = 1;
            $this->session->addFlashes('info', "La page demandée n'existe pas.");
            $this->redirect($this->env["URL_DOMAIN"] . "admin/comments");
        }
        $comments = $this->paginator->paginate($this->commentRepository, ["is_active" => 0], self::MAX_COMMENT_PER_PAGE, $pageData);

        return new Response($this->view->render([
            'template' => 'backoffice/pages/comments',
            'comments' => $comments,
            'max_page' => $maxPage,
            'current_page' => $pageData,
            'url_to_paginate' => $this->env["URL_DOMAIN"] . "admin/comments?page="
        ]), 200);
    }
}
