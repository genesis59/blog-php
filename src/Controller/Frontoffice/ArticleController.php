<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Model\ArticleService;
use App\Service\Model\CommentService;
use App\Service\Pagination\PaginationTrait;
use App\Service\Validator;
use App\View\View;

class ArticleController
{
    use ControllerTrait;
    use PaginationTrait;

    const MAX_ARTICLE_PER_PAGE = 4;
    const MAX_COMMENT_PER_PAGE = 5;
    const ARTICLE_ORDER_DEFAULT = ['created_at' => 'DESC'];
    const COMMENT_ORDER_DEFAULT = ['created_at' => 'DESC'];
    const HEADER_TITLE_PAGE_ARTICLES = "Liste des articles";
    const ANCHOR_COMMENT = '#comment';
    const ANCHOR_ARTICLE_LIST = '#articles';
    const ANCHOR_ARTICLE = '#article';

    /**
     * @param ArticleService $articleService
     * @param View $view
     * @param array<string> $env
     */
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly CommentService $commentService,
        private readonly View $view,
        private readonly array $env,
        private readonly Session $session,
        private readonly Validator $validator,
    ) {
    }

    public function articles(int $pageData = 1): Response
    {
        $articles = $this->articleService->getSomeHydratedArticlesPaginate(self::MAX_ARTICLE_PER_PAGE, $pageData, self::ARTICLE_ORDER_DEFAULT);
        $maxPage = $this->getMaxPage($this->articleService->getTotalRows(), self::MAX_ARTICLE_PER_PAGE);
        $currentPage = $this->getCurrentPage($pageData, $maxPage);

        if ($currentPage !== $pageData) {
            $this->session->addFlashes('info', "La page demandée n'existe pas.");
        }

        $urlToGoPaginate = $this->env["URL_DOMAIN"] . "articles?page=";

        return new Response($this->view->render([
            'template' => 'articles',
            'url_domain' => $this->env["URL_DOMAIN"],
            'articles' => $articles,
            'max_page' => $maxPage,
            'current_page' => $currentPage,
            'target' => self::ANCHOR_ARTICLE_LIST,
            'url_to_paginate' => $urlToGoPaginate,
            'header_title' => self::HEADER_TITLE_PAGE_ARTICLES
        ]), 200);
    }

    public function article(int $id, Request $request, int $pageData = 1): Response
    {
        $article = $this->articleService->getOne($id);
        if (!$article) {
            return $this->redirect($this->env['URL_DOMAIN'] . "articles");
        }
        $maxPage = $this->getMaxPage($this->commentService->getTotalRows($article), self::MAX_COMMENT_PER_PAGE);
        $currentPage = $this->getCurrentPage($pageData, $maxPage);

        if ($currentPage !== $pageData) {
            $this->session->addFlashes('info', "La page demandée n'existe pas.");
        }

        $user = $this->getUser();

        if ($user && $request->server()->get("REQUEST_METHOD") === "POST") {
            if ($this->validator->formAddCommentIsValid($request)) {
                $this->commentService->addNewComment($article, $user, $request->request()->get("commentaire"));
                return $this->redirect($this->env['URL_DOMAIN'] . "article?numero=" . $article->getId());
            }
            $this->session->addFlashes('danger', 'Une problème est survenu le commentaire ne peut être soumis.');
        }

        $comments = $this->commentService->getSomeHydratedCommentsPaginate($article, self::MAX_COMMENT_PER_PAGE, $pageData, self::COMMENT_ORDER_DEFAULT);
        $idPreviousArticle = $this->articleService->getPreviousArticleId($article);
        $idNextArticle = $this->articleService->getNextArticleId($article);
        $numero = "1";
        if ($request->query()->has('numero')) {
            $numero = $request->query()->get('numero');
        }
        $urlToGoPaginate = $this->env["URL_DOMAIN"] . "article?numero=" . $numero . "&page=";
        return new Response($this->view->render([
            'template' => 'article',
            'article' => $article,
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => $article->getTitle(),
            'next_id' => $idNextArticle,
            'previous_id' => $idPreviousArticle,
            'comments' => $comments,
            'max_page' => $maxPage,
            'current_page' => $currentPage,
            'target' => self::ANCHOR_COMMENT,
            'target_next_previous' => self::ANCHOR_ARTICLE,
            'url_to_paginate' => $urlToGoPaginate,
            'user' => $user,
        ]), 200);
    }
}
