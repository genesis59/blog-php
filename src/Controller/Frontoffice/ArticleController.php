<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Service\Http\Response;
use App\Service\Model\ArticleService;
use App\View\View;

class ArticleController
{
    const MAX_ARTICLE_PER_PAGE = 4;
    const ARTICLE_ORDER_DEFAULT = ['created_at' => 'DESC'];
    /**
     * @param ArticleService $articleService
     * @param View $view
     * @param array<string> $env
     */
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly View $view,
        private readonly array $env
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
        return new Response($this->view->render([
            'template' => 'articles',
            'url_domain' => $this->env["URL_DOMAIN"],
            'articles' => $articles,
            'max_page' => $maxPage,
            'current_page' => $this->articleService->getCurrentPage($pageData, $maxPage),
            'empty' => $empty,
        ]), 200);
    }

    public function article(int $id): Response
    {
        $article = $this->articleService->getOne($id);
        return new Response($this->view->render([
            'template' => 'article',
            'article' => $article,
            'url_domain' => $this->env["URL_DOMAIN"]
        ]), 200);
    }
}
