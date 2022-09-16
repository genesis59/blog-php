<?php

declare(strict_types=1);

namespace App\Service\Http;

class RedirectResponse extends Response
{
    public function __construct(string $url)
    {
        parent::__construct('', 302, [
            "content_type" => "text/html",
            "charset" => "UTF-8"
        ]);
        $this->redirect($url);
    }

    private function redirect(string $url): void
    {
        header("Location: " . $url, true, 302);
    }
}
