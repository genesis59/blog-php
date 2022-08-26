<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\View\View;

class HomeController
{
    /**
     * @param ArticleRepository<object> $articleRepository
     * @param UserRepository<object> $userRepository
     * @param View $view
     */
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly View $view
    ) {
    }

    /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(): Response
    {
        /** @var array<int,Article> $articles */
        $articles = $this->articleRepository->findAll();
        if ($articles) {
            foreach ($articles as $article) {
                /** @var User $user */
                $user = $this->userRepository->find($article->getUser()->getId());
                $article->setUser($user);
            }
        }
        return new Response($this->view->render([
            'template' => 'home',
            'data' => [
                'articles' => $articles
            ]
        ]));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function contact(Request $request): Response
    {
        return new Response($this->view->render(['template' => 'home']));
    }
}
