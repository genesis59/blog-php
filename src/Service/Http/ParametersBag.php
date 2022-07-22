<?php

declare(strict_types=1);

namespace App\Service\Http;

class ParametersBag
{
    /**
     * @var array<mixed>
     */
    protected array $parameters;

    /**
     * @param array<mixed> $parameters
     */
    public function __construct(array &$parameters)
    {
        $this->parameters = &$parameters;
    }

    /**
     * @return mixed[]|null
     */
    public function all(): ?array
    {
        return $this->parameters;
    }

    public function get(string $key): mixed
    {
        return $this->has($key) ? $this->parameters[$key] : null;
    }

    public function has(string $key): bool
    {
        return isset($this->parameters[$key]);
    }

    public function set(string $key, mixed $value): void
    {
        $this->parameters[$key] = $value;
    }
}
