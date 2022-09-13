<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\ControllerTrait;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\MailerService;
use App\Service\Model\ArticleService;
use App\Service\Validator;
use App\View\View;

class HomeController
{
    use ControllerTrait;

    const NUMBER_LAST_ARTICLE_ON_HOMEPAGE = 4;

    /**
     * @param array<string> $env
     */
    public function __construct(
        private readonly ArticleService $articleService,
        private readonly View $view,
        private readonly Validator $validator,
        private readonly array $env,
        private readonly Session $session
    ) {
    }

    public function index(Request $request, MailerService $mailerService): Response
    {
        $user = $this->getUser();
        $fromContact = false;
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            if ($this->validator->formContactIsValid($request)) {
                $mailerService->sendContactEmail(
                    $request->request()->get('email'),
                    $request->request()->get('message'),
                    $request->request()->get('nom'),
                    $request->request()->get('prenom')
                );
            }
            $fromContact = true;
        }
        return new Response($this->view->render([
            'template' => 'home',
            'user' => $user,
            'from_contact' => $fromContact,
            'form' => [
                'nom' => $request->request()->get('nom') ?? "",
                'prenom' => $request->request()->get('prenom') ?? "",
                'email' => $request->request()->get('email') ?? "",
                'message' => $request->request()->get('message') ?? null,
                'confidentialite' => $request->request()->get('confidentialite') ?? "",
            ],
            'url_domain' => $this->env["URL_DOMAIN"],
            'articles' => $this->articleService->getSomeHydratedArticlesPaginate(self::NUMBER_LAST_ARTICLE_ON_HOMEPAGE, 1),
        ]), 200);
    }
}
