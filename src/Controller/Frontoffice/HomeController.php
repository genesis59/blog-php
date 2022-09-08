<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\MailerService;
use App\Service\Validator;
use App\View\View;


class HomeController
{
    /**
     * @param ArticleRepository $articleRepository
     * @param UserRepository $userRepository
     * @param View $view
     * @param Validator $validator
     * @param array<string> $env
     */
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly UserRepository $userRepository,
        private readonly View $view,
        private readonly Validator $validator,
        private readonly array $env
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
            'url_domain' => $this->env["URL_DOMAIN"],
            'articles' => $articles
        ]), 200);
    }

    /**
     * @param Request $request
     * @param MailerService $mailerService
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function contact(Request $request, MailerService $mailerService)
    {
        $nomIsValid = $this->validator->inputTextIsValid("nom", $request->request()->get('nom'), 2, 50);
        $prenomIsValid = $this->validator->inputTextIsValid("prénom", $request->request()->get('prenom'), 2, 50);
        $emailIsValid = $this->validator->inputEmailIsValid($request->request()->get('email'));
        $messageIsValid = $this->validator->inputTextIsValid("message", $request->request()->get('message'), 10);
        $acceptedconfidentiality = $this->validator->inputCheckBoxIsChecked($request->request()->get('confidentialite'), "accept");

        if ($nomIsValid && $prenomIsValid && $emailIsValid && $messageIsValid && $acceptedconfidentiality) {
            $mailerService->sendContactEmail(
                $request->request()->get('email'),
                $request->request()->get('message'),
                $request->request()->get('nom'),
                $request->request()->get('prenom')
            );
            return new Response($this->view->render([
                'template' => 'home'
            ]), 201);
        }
        return new Response($this->view->render([
            'template' => 'home'
        ]), 400);
    }
}
