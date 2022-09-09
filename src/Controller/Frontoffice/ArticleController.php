<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Model\ArticleService;
use App\View\View;

class ArticleController
{
    const MAX_ARTICLE_PER_PAGE = 4;
    const ARTICLE_ORDER_DEFAULT = ['created_at' => 'DESC'];
    const HEADER_TITLE_PAGE_ARTICLES = "Liste des articles";

    /**
     * @param ArticleService $articleService
     * @param View $view
     * @param array<string> $env
     */
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly View $view,
        private readonly array $env,
        private readonly Session $session
    ) {
    }

    public function articles(int $pageData = 1): Response
    {

        $empty = false;
        $maxPage = 1;
        $articles = $this->articleService->getSomeHydratedArticlesPaginate(self::MAX_ARTICLE_PER_PAGE, $pageData, self::ARTICLE_ORDER_DEFAULT);
        if (!$articles) {
            $empty = true;
        }
        if (!$empty) {
            $maxPage = $this->articleService->getMaxPage(self::MAX_ARTICLE_PER_PAGE);
        }
        $currentPage = $this->articleService->getCurrentPage($pageData, $maxPage);
        if ($currentPage !== $pageData) {
            $this->session->addFlashes('info', "La page demandée n'existe pas.");
        }
        return new Response($this->view->render([
            'template' => 'articles',
            'url_domain' => $this->env["URL_DOMAIN"],
            'articles' => $articles,
            'max_page' => $maxPage,
            'current_page' => $currentPage,
            'empty' => $empty,
            'header_title' => self::HEADER_TITLE_PAGE_ARTICLES
        ]), 200);
    }

    public function article(int $id): Response
    {
        $article = $this->articleService->getOne($id);
        if (!$article) {
            return $this->articles();
        }
        return new Response($this->view->render([
            'template' => 'article',
            'article' => $article,
            'url_domain' => $this->env["URL_DOMAIN"],
            'header_title' => $article->getTitle(),
            'max_article' => $this->articleService->getCountTotalRows()
        ]), 200);
    }
}
