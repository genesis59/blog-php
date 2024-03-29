<?php

declare(strict_types=1);

namespace App\View;

use App\Service\CsrfValidator;
use Twig\Environment;
use App\Service\Http\Session\Session;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

final class View
{
    private readonly Environment $twig;

    /**
     * @param Session $session
     * @param CsrfValidator $tokenGenerator
     * @param \App\Service\Environment $environment
     */
    public function __construct(
        private readonly Session $session,
        private readonly CsrfValidator $tokenGenerator,
        private readonly \App\Service\Environment $environment
    ) {
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader);
    }

    /**
     * @param array<string,mixed> $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(array $data): string
    {

        $data['data']['session'] = $this->session->toArray();
        $data['token'] = $this->tokenGenerator->generateToken();
        $data['data']['flashes'] = $this->session->getFlashes();
        $data['url_domain'] = $this->environment->get("URL_DOMAIN");
        $data['user'] = $this->session->get('user') ?? null;

        return $this->twig->render("${data['template']}.html.twig", $data);
    }
}
