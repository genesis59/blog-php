<?php

declare(strict_types=1);

namespace App\Service\Http\Session;

final class Session
{
    private readonly SessionParametersBag $sessionParamBag; // $_SESSION

    public function __construct()
    {
        session_start();
        $this->sessionParamBag = new SessionParametersBag($_SESSION);
    }

    public function set(string $name, mixed $value): void
    {
        $this->sessionParamBag->set($name, $value);
    }

    public function get(string $name): mixed
    {
        return $this->sessionParamBag->get($name);
    }

    /**
     * @return array<string>|null
     */
    public function toArray(): ?array
    {
        return $this->sessionParamBag->all();
    }

    public function remove(string $name): void
    {
        $this->sessionParamBag->unset($name);
    }


    public function addFlashes(string $type, string $message): void
    {

        if ($this->get('flashes') !== null) {
            $flashes = $this->getFlashes();
            $flashes[$type][] = $message;
        } else {
            $flashes = [$type => [$message]];
        }
        $this->set('flashes', $flashes);
    }

    /**
     * @return array<string,array<string>>|null
     */
    public function getFlashes(): ?array
    {
        $flashes = $this->get('flashes');
        $this->remove('flashes');

        return $flashes;
    }
}
