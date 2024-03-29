<?php

namespace App\Controller\Backoffice;

use App\Controller\ControllerTrait;
use App\Enum\Role;
use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\ArticleRepository;
use App\Model\Repository\UserRepository;
use App\Service\CsrfValidator;
use App\Service\Environment;
use App\Service\Http\Request;
use App\Service\Http\Response;
use App\Service\Http\Session\Session;
use App\Service\Paginator;
use App\View\View;

class AdminUserController
{
    use ControllerTrait;

    const MAX_USER_PER_PAGE = 5;

    private function toggleRoleUsers(User $user): void
    {
        $newRole = Role::USER;
        if ($user->getRoleUsers() === Role::USER) {
            $newRole = Role::EDITOR;
        }
        $user->setRoleUsers($newRole);
        $this->userRepository->update($user);
    }

    private function anonymizedArticlesOfDeleteUser(User $user): void
    {
        // On anonymise les articles de cet utilisateur
        /** @var User $userAnonyme */
        $userAnonyme = $this->userRepository->find(1);

        /** @var Article[] $articles */
        $articles = $this->articleRepository->findBy(["id_user" => $user->getId()]);
        if ($articles !== null) {
            foreach ($articles as $article) {
                $article->setUser($userAnonyme);
                $this->articleRepository->update($article);
            }
        }
        $this->userRepository->delete($user);
    }

    /**
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param View $view
     * @param Session $session
     * @param Paginator $paginator
     * @param CsrfValidator $csrfValidator
     * @param Environment $environment
     */
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ArticleRepository $articleRepository,
        private readonly View $view,
        private readonly Session $session,
        private readonly Paginator $paginator,
        private readonly CsrfValidator $csrfValidator,
        private readonly Environment $environment
    ) {
    }

    public function users(Request $request): Response
    {
        if ($request->server()->get("REQUEST_METHOD") === "POST") {
            $this->csrfValidator->validateCsrfToken($request);
            if ($request->request()->has("user")) {
                /** @var User $user */
                $user = $this->userRepository->find($request->request()->get("user"));
                if ($user !== null) {
                    $this->toggleRoleUsers($user);
                }
            }
            if ($request->request()->has("typeAction") && $request->request()->get("typeAction") == "deleteUser") {
                /** @var User $user */
                $user = $this->userRepository->find($request->request()->get("id"));
                if ($user !== null) {
                    $this->anonymizedArticlesOfDeleteUser($user);
                }
            }
        }
        $pageData = $request->query()->has("page") && (int)$request->query()->get("page") !== 0 ? (int)$request->query()->get("page") : 1;
        $users = $this->paginator->paginate($this->userRepository, [], self::MAX_USER_PER_PAGE, $pageData);

        if ($users !== null && count($users) > 2) {
            // Récupération des données pour la pagination
            $maxPage = $this->paginator->getMaxPage($this->userRepository->count() - 2, self::MAX_USER_PER_PAGE);
            if (!$this->paginator->isExistingPage($pageData, $maxPage)) {
                $pageData = 1;
                $this->session->addFlashes('info', "La page demandée n'existe pas.");
                $this->redirect($this->environment->get("URL_DOMAIN") . "admin/users");
            }
        }
        return new Response($this->view->render([
            'template' => 'backoffice/pages/users',
            'users' => $users,
            'max_page' => $maxPage ?? 1,
            'current_page' => $pageData,
            'url_to_paginate' => $this->environment->get("URL_DOMAIN") . "admin/users?page="
        ]), 200);
    }
}
