<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Controller\ControllerTrait;
use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Paginator;
use App\Service\Validator\FormValidator;
use App\View\View;

class AdminArticleController
{
    use ControllerTrait;

    const MAX_ARTICLE_PER_PAGE = 5;

    /**
     * @param ArticleRepository $articleRepository
     * @param UserRepository $userRepository
     * @param View $view
     * @param array<string,string> $env
     * @param Session $session
     * @param FormValidator $formValidator
     * @param Paginator $paginator
     */
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly View $view,
        private readonly array $env,
        private readonly Session $session,
        private readonly FormValidator $formValidator,
        private readonly Paginator $paginator
    ) {
    }

    public function index(Request $request): Response
    {
        if ($request->server()->get("REQUEST_METHOD") === "POST" && $request->request()->get("typeAction") == "deleteArticle") {
            $idArticle = $request->request()->has("id") ? (int)$request->request()->get("id") : 0;
            /** @var Article $article */
            $article = $this->articleRepository->find($idArticle);
            if ($article == null) {
                $this->session->addFlashes("danger", "Une problème est survenu l'article ne peut être supprimé.");
                $this->redirect($request->server()->get('HTTP_REFERER'));
            }
            $this->articleRepository->delete($article);
            $this->session->addFlashes("success", "Article suprimmé.");
        }
        $pageData = $request->query()->has("page") && (int)$request->query()->get("page") !== 0 ? (int)$request->query()->get("page") : 1;
        /** @var Article[] $articles */
        $articles = $this->paginator->paginate($this->articleRepository, [], self::MAX_ARTICLE_PER_PAGE, $pageData);
        $maxPage = 1;
        if ($articles !== null) {
            $maxPage = $this->paginator->getMaxPage($this->articleRepository->count(), self::MAX_ARTICLE_PER_PAGE);
            if (!$this->paginator->isExistingPage($pageData, $maxPage)) {
                $pageData = 1;
                $this->session->addFlashes('info', "La page demandée n'existe pas.");
                $this->redirect($this->env["URL_DOMAIN"] . "admin?page=");
            }
        }
        return new Response($this->view->render([
            'template' => 'backoffice/pages/articles',
            'articles' => $articles,
            'max_page' => $maxPage,
            'current_page' => $pageData,
            'url_to_paginate' => $this->env["URL_DOMAIN"] . "admin?page="
        ]), 200);
    }

    public function new(Request $request): Response
    {
        if ($request->server()->get("REQUEST_METHOD") === "POST" && $this->formValidator->formNewArticleIsValid($request)) {
            if (!$this->getUser()) {
                $this->redirect($this->env["URL_DOMAIN"]);
            }
            $article = new Article();
            $article->setTitle($request->request()->get("title"));
            $article->setChapo($request->request()->get("chapo"));
            $article->setContent($request->request()->get("content"));
            /** @var User $user */
            $user = $this->getUser();
            $article->setUser($user);
            $this->articleRepository->create($article);
            $this->session->addFlashes("success", "L'article a bien été créé.");
            $this->redirect($this->env["URL_DOMAIN"] . "admin");
        }
        return new Response($this->view->render([
            'template' => 'backoffice/pages/newEditArticle',
            'type_form' => 'new',
            'form' => [
                'title' => $request->request()->has("title") ? $request->request()->get("title") : null,
                'chapo' => $request->request()->has("chapo") ? $request->request()->get("chapo") : null,
                'content' => $request->request()->has("content") ? $request->request()->get("content") : null
            ]
        ]), 200);
    }

    public function edit(Request $request): Response
    {
        $idArticle = $request->query()->has("numero") ? (int)$request->query()->get("numero") : null;

        /** @var Article $article */
        $article = $this->articleRepository->find($idArticle ?? 0);

        if ($article == null) {
            $this->session->addFlashes("danger", "Désolé l'article demandé n'existe pas");
            $this->redirect($this->env["URL_DOMAIN"] . "admin");
        }
        if ($request->server()->get("REQUEST_METHOD") === "POST" && $this->formValidator->formEditArticleIsValid($request)) {
            /** @var User $user */
            $user = $this->userRepository->find((int)$request->request()->get("author"));
            $article->setTitle($request->request()->get("title"));
            $article->setChapo($request->request()->get("chapo"));
            $article->setContent($request->request()->get("content"));
            $article->setUser($user);
            $this->articleRepository->update($article);
            $this->session->addFlashes("success", "L'article a bien été modifié.");
            $this->redirect($this->env["URL_DOMAIN"] . "admin");
        }
        $authors = $this->userRepository->selectUserWithRoleEditorAndAdmin();
        return new Response($this->view->render([
            'template' => 'backoffice/pages/newEditArticle',
            'type_form' => 'edit',
            'current_user' => $this->getUser(),
            'authors' => $authors ?? null,
            'article' => $article,
            'form' => [
                'title' => $request->request()->has("title") ? $request->request()->get("title") : $article->getTitle(),
                'chapo' => $request->request()->has("chapo") ? $request->request()->get("chapo") : $article->getChapo(),
                'content' => $request->request()->has("content") ? $request->request()->get("content") : $article->getContent(),
                'author_ongoing_selected' => $request->request()->get("author") ?? null
            ]
        ]), 200);
    }
}
