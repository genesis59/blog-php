<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Model\Entity\Article;
use App\Model\Repository\ArticleRepository;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\MailerService;
use App\Service\Paginator;
use App\Service\Validator;
use App\View\View;

class HomeController
{
    use ControllerTrait;

    const NUMBER_LAST_ARTICLE_ON_HOMEPAGE = 4;

    public function __construct(
        private readonly View $view,
        private readonly Validator $validator,
        private readonly Session $session,
        private readonly Paginator $paginator,
        private readonly ArticleRepository $articleRepository
    ) {
    }

    public function index(Request $request, MailerService $mailerService): Response
    {
        $flashFromContact = false;
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            if ($this->validator->formContactIsValid($request)) {
                $mailerService->sendContactEmail(
                    $request->request()->get('email'),
                    $request->request()->get('message'),
                    $request->request()->get('nom'),
                    $request->request()->get('prenom')
                );
            }
            $flashFromContact = true;
        }
        /** @var array<int,Article> $articles */
        $articles = $this->paginator->paginate($this->articleRepository, [], self::NUMBER_LAST_ARTICLE_ON_HOMEPAGE, 1);
        return new Response($this->view->render([
            'template' => 'frontoffice/pages/home',
            'flash_from_contact' => $flashFromContact,
            'form' => [
                'nom' => $request->request()->get('nom') ?? "",
                'prenom' => $request->request()->get('prenom') ?? "",
                'email' => $request->request()->get('email') ?? "",
                'message' => $request->request()->get('message') ?? null,
                'confidentialite' => $request->request()->get('confidentialite') ?? "",
            ],
            'articles' => $articles,
        ]), 200);
    }

    public function privacy(): Response
    {
        return new Response($this->view->render([
            'template' => 'frontoffice/pages/privacy',
            'header_title' => 'Politiques de confidentialité',
        ]), 200);
    }
}
