<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Session\Session;

class TokenGenerator
{
    public function __construct(private readonly Session $session)
    {
    }

    public function generateToken(): string
    {
        $token = base_convert(hash('sha256', time() . mt_rand()), 16, 36);
        $this->session->set("token", $token);
        return $token;
    }

    public function validateCsrfToken(string $token): bool
    {
        return true;
    }
}
