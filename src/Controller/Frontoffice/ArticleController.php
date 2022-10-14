<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Model\Entity\Article;
use App\Model\Entity\Comment;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Service\CsrfValidator;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Paginator;
use App\Service\Validator\FormValidator;
use App\View\View;

class ArticleController
{
    use ControllerTrait;

    const MAX_COMMENT_PER_PAGE = 5;
    const MAX_ARTICLE_PER_PAGE = 4;

    /**
     * @param ArticleRepository $articleRepository
     * @param CommentRepository $commentRepository
     * @param View $view
     * @param array<string,string> $env
     * @param Session $session
     * @param FormValidator $formValidator
     * @param Paginator $paginator
     */
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly CommentRepository $commentRepository,
        private readonly array $env,
        private readonly View $view,
        private readonly Session $session,
        private readonly FormValidator $formValidator,
        private readonly Paginator $paginator,
        private readonly CsrfValidator $csrfValidator
    ) {
    }

    public function articles(Request $request): Response
    {
        $pageData = $request->query()->has("page") && (int)$request->query()->get("page") !== 0 ? (int)$request->query()->get("page") : 1;
        /** @var Article[] $articles */
        $articles = $this->paginator->paginate($this->articleRepository, [], self::MAX_ARTICLE_PER_PAGE, $pageData);
        $maxPage = 1;
        if ($articles !== null) {
            $maxPage = $this->paginator->getMaxPage($this->articleRepository->count(), self::MAX_ARTICLE_PER_PAGE);
            if (!$this->paginator->isExistingPage($pageData, $maxPage)) {
                $pageData = 1;
                $this->session->addFlashes('info', "La page demandée n'existe pas.");
                $this->redirect($this->env["URL_DOMAIN"] . "articles?page=");
            }
        }
        return new Response($this->view->render([
            'template' => 'frontoffice/pages/articles',
            'articles' => $articles,
            'max_page' => $maxPage,
            'current_page' => $pageData,
            'url_to_paginate' => $this->env["URL_DOMAIN"] . "articles?page=",
            'header_title' => "Liste des articles"
        ]), 200);
    }

    public function article(Request $request, string $slug): Response
    {
        $pageData = $request->query()->has("page") ? (int)$request->query()->get("page") : 1;
        /** @var Article $article */
        $article = $this->articleRepository->findOneBy(["slug" => $slug]);

        if ($article == null) {
            $this->session->addFlashes('info', "L'article demandée n'existe pas.");
            $this->redirect($this->env['URL_DOMAIN'] . "articles");
        }
        /** @var User $user */
        $user = $this->getUser();
        if ($user !== null && $request->server()->get("REQUEST_METHOD") === "POST") {
            $this->csrfValidator->validateCsrfToken($request);
            if ($this->formValidator->formAddCommentIsValid($request)) {
                try {
                    $newComment = new Comment();
                    $newComment->setCreatedAt(new \DateTime());
                    $newComment->setIsActive(false);
                    $newComment->setUser($user);
                    $newComment->setArticle($article);
                    $newComment->setContent($request->request()->get("commentaire"));
                    $this->commentRepository->create($newComment);
                    $this->session->addFlashes('success', 'Merci pour votre commentaire. Nous le traiterons dans les plus brefs délais');
                } catch (\Exception $e) {
                    $this->session->addFlashes('danger', 'Une problème est survenu le commentaire ne peut être soumis.');
                }
                $this->redirect($this->env['URL_DOMAIN'] . "article/" . $article->getSlug());
            }
            $this->session->addFlashes('danger', 'Une problème est survenu le commentaire ne peut être soumis.');
        }
        // Récupération des données pour la pagination
        $maxPage = $this->paginator->getMaxPage($this->commentRepository->count(['id_article' => $article->getId(), 'is_active' => 1]), self::MAX_COMMENT_PER_PAGE);
        if (!$this->paginator->isExistingPage($pageData, $maxPage)) {
            $pageData = 1;
            $this->session->addFlashes('info', "La page demandée n'existe pas.");
        }
        /** @var array<int,Comment> $comments */
        $comments = $this->paginator->paginate($this->commentRepository, ['id_article' => $article->getId(), 'is_active' => 1], self::MAX_COMMENT_PER_PAGE, $pageData);
        /** @var Article $previousArticle */
        $previousArticle = $this->articleRepository->getPreviousEntity($article);
        /** @var Article $nextArticle */
        $nextArticle = $this->articleRepository->getNextEntity($article);

        return new Response($this->view->render([
            'template' => 'frontoffice/pages/article',
            'header_title' => $article->getTitle(),
            'article' => $article,
            'comments' => $comments,
            'next_entity' => $nextArticle,
            'previous_entity' => $previousArticle,
            'max_page' => $maxPage,
            'current_page' => $pageData,
            'url_to_paginate' => $this->env["URL_DOMAIN"] . "article/" . $article->getSlug() . "?page=",
        ]), 200);
    }
}
