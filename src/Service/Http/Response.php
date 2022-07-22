<?php

declare(strict_types=1);

namespace App\Service\Http;

final class Response
{
    /**
     * @param string $content
     * @param int $statusCode
     * @param array<string,string> $headers
     */
    public function __construct(
        private readonly string $content = '',
        private readonly int $statusCode = 200,
        private readonly array $headers = []
    ) {
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        //echo $this->statusCode . ' ' . implode(',', $this->headers); // TODO Il faut renvoyer aussi le status de la réponse
        echo $this->content;
    }
}
