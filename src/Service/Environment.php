<?php

declare(strict_types=1);

namespace App\Service;

class Environment
{
    /**
     * @var array <string,string>
     */
    public static array $env;

    /**
     * @return array<string,string>
     */
    private function getVariablesEnvironment(): array
    {
        /** @var array<int,string> $envFileList */
        $envFileList = file(__DIR__ . '/../../.env');
        $envs = [];
        foreach ($envFileList as $value) {
            $env = explode('=', $value, 2);
            $envs[$env[0]] = trim($env[1]);
        }
        return $envs;
    }

    public function __construct()
    {
        Environment::$env = $this->getVariablesEnvironment();
    }
}
