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
        private readonly array $headers = [
            "content_type" => "text/html",
            "charset" => "UTF-8"
        ]
    ) {
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        header('Content-Type: ' . $this->headers["content_type"] . '; charset=' . $this->headers["charset"]);
        echo $this->content;
    }
}
