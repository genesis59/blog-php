<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\Role;
use App\Model\Entity\Article;
use App\Model\Entity\Comment;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Paginator;
use App\Service\Validator;
use App\View\View;

class ArticleController
{
    use ControllerTrait;

    const MAX_ARTICLE_PER_PAGE_FRONT = 4;
    const MAX_ARTICLE_PER_PAGE_BACK = 5;
    const MAX_COMMENT_PER_PAGE = 5;
    const DATA_ARTICLES_BACK = [
        'template' => 'backoffice/pages/articles',
        'url_to_paginate' => "admin?page=",
        'header_title' => ""
    ];
    const DATA_ARTICLES_FRONT = [
        'template' => 'frontoffice/pages/articles',
        'url_to_paginate' => "articles?page=",
        'header_title' => "Liste des articles"
    ];

    /**
     * @var array<string,string>
     */
    private array $dataOffice;

    /**
     * @var int
     */
    private int $articlesPerPage;

    private function setOfficeVariable(bool $frontOffice): void
    {
        $this->dataOffice = self::DATA_ARTICLES_FRONT;
        $this->articlesPerPage = self::MAX_ARTICLE_PER_PAGE_FRONT;
        if (!$frontOffice) {
            $this->dataOffice = self::DATA_ARTICLES_BACK;
            $this->articlesPerPage = self::MAX_ARTICLE_PER_PAGE_BACK;
        }
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param CommentRepository $commentRepository
     * @param View $view
     * @param array<string,string> $env
     * @param Session $session
     * @param Validator $validator
     * @param Paginator $paginator
     */
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly CommentRepository $commentRepository,
        private readonly View $view,
        private readonly array $env,
        private readonly Session $session,
        private readonly Validator $validator,
        private readonly Paginator $paginator
    ) {
    }

    public function articles(Request $request, bool $frontOffice = true): Response
    {
        $this->setOfficeVariable($frontOffice);

        $pageData = $request->query()->has("page") && (int)$request->query()->get("page") !== 0 ? (int)$request->query()->get("page") : 1;

        /** @var Article[] $articles */
        $articles = $this->paginator->paginate($this->articleRepository, [], $this->articlesPerPage, $pageData);
        $maxPage = 1;
        if ($articles !== null) {
            $maxPage = $this->paginator->getMaxPage($this->articleRepository->count(), $this->articlesPerPage);
            if (!$this->paginator->isExistingPage($pageData, $maxPage)) {
                $pageData = 1;
                $this->session->addFlashes('info', "La page demandée n'existe pas.");
                $this->redirect($this->env["URL_DOMAIN"] . $this->dataOffice['url_to_paginate']);
            }
        }

        return new Response($this->view->render([
            'template' => $this->dataOffice['template'],
            'articles' => $articles,
            'max_page' => $maxPage,
            'current_page' => $pageData,
            'url_to_paginate' => $this->env["URL_DOMAIN"] . $this->dataOffice['url_to_paginate'],
            'header_title' => $this->dataOffice['header_title']
        ]), 200);
    }

    public function article(Request $request): Response
    {

        $id = $request->query()->has("numero") ? (int)$request->query()->get("numero") : 0;

        $pageData = $request->query()->has("page") && (int)$request->query()->get("page") !== 0 ? (int)$request->query()->get("page") : 1;
        /** @var Article $article */
        $article = $this->articleRepository->find($id);

        if ($article == null) {
            $this->session->addFlashes('info', "La page demandée n'existe pas.");
            $this->redirect($this->env['URL_DOMAIN'] . "articles");
        }
        /** @var User $user */
        $user = $this->getUser();

        if ($user !== null && $request->server()->get("REQUEST_METHOD") === "POST") {
            if ($this->validator->formAddCommentIsValid($request)) {
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
                $this->redirect($this->env['URL_DOMAIN'] . "article?numero=" . $article->getId());
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
            'url_to_paginate' => $this->env["URL_DOMAIN"] . "article?numero=" . $id . "&page=",
        ]), 200);
    }

    public function newEdit(Request $request, bool $isNew = true): Response
    {
        if ($request->server()->get("REQUEST_METHOD") === "POST" && $this->validator->formNewEditArticleIsValid($request, $isNew)) {
            if (!$isNew) {
                $this->updateArticle($request);
                $this->redirect($this->env["URL_DOMAIN"] . "admin");
            }
            if (!$this->getUser()) {
                $this->redirect($this->env["URL_DOMAIN"]);
            }
            $this->addArticle($request);
            $this->redirect($this->env["URL_DOMAIN"] . "admin");
        }
        $idArticle = $request->query()->has("numero") ? (int)$request->query()->get("numero") : null;
        $article = null;
        if ($idArticle !== null) {
            /** @var Article $article */
            $article = $this->articleRepository->find($idArticle);
            if ($article == null) {
                $this->session->addFlashes("danger", "Désolé l'article demandé n'existe pas");
                $this->redirect($this->env["URL_DOMAIN"] . "admin");
            }
        }
        $authors = $this->userRepository->findAll();
        return new Response($this->view->render([
            'template' => 'backoffice/pages/newEditArticle',
            'is_new' => $isNew,
            'authors' => $authors ?? null,
            'form' => [
                'title' => $article === null ? $request->request()->get("title") ?? null : $article->getTitle(),
                'chapo' => $article === null ? $request->request()->get("chapo") ?? null : $article->getChapo(),
                'content' => $article === null ? $request->request()->get("content") ?? null : $article->getContent(),
                'author' => $article === null ? $request->request()->get("author") ?? null : $article->getUser()->getId(),
                'id' => $article === null ? $request->request()->get("id") ?? null : $article->getUser()->getId()
            ]
        ]), 200);
    }

    private function addArticle(Request $request): void
    {
        $article = new Article();
        $article->setTitle($request->request()->get("title"));
        $article->setChapo($request->request()->get("chapo"));
        $article->setContent($request->request()->get("content"));
        /** @var User $user */
        $user = $this->getUser();
        $article->setUser($user);
        $this->articleRepository->create($article);
        $this->session->addFlashes("success", "L'article a bien été créé.");
    }

    private function updateArticle(Request $request): void
    {
        /** @var Article $article */
        $article = $this->articleRepository->find((int)$request->request()->get("id"));
        /** @var User $user */
        $user = $this->userRepository->find((int)$request->request()->get("author"));
        $article->setTitle($request->request()->get("title"));
        $article->setChapo($request->request()->get("chapo"));
        $article->setContent($request->request()->get("content"));
        $article->setUser($user);
        $this->articleRepository->update($article);
        $this->session->addFlashes("success", "L'article a bien été modifié.");
    }
}
