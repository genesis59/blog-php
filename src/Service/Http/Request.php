<?php

declare(strict_types=1);

namespace App\Service\Http;

final class Request
{
    private readonly ParametersBag $query; // $_GET
    private readonly ParametersBag $request; // $_POST
    private readonly ParametersBag $files; // $_FILES
    private readonly ParametersBag $server; // $_SERVER

    /**
     * @param array<string,mixed> $parameters
     * @return array<string,mixed>
     */
    private function handleProtectionXSS(array &$parameters): array
    {
        $parametersProtected = [];
        $parametersProtected2 = [];
        foreach ($parameters as $key => $parameter) {
            if (is_array($parameter)) {
                foreach ($parameter as $key2 => $parameter2) {
                    $parametersProtected2[$key2] = htmlspecialchars($parameter2);
                }
            }
            $parametersProtected[$key] = is_array($parameter) ? $parametersProtected2 : htmlspecialchars($parameter);
        }
        return $parametersProtected;
    }

    /**
     * @param array<mixed> $query
     * @param array<mixed> $request
     * @param array<mixed> $files
     * @param array<mixed> $server
     */
    public function __construct(array $query, array $request, array $files, array $server)
    {
        $protectedQuery = $this->handleProtectionXSS($query);
        $protectedRequest = $this->handleProtectionXSS($request);
        $protectedFile = $this->handleProtectionXSS($files);
        $this->query = new ParametersBag($protectedQuery);
        $this->request = new ParametersBag($protectedRequest);
        $this->files = new ParametersBag($protectedFile);
        $this->server = new ParametersBag($server);
    }

    public function query(): ParametersBag
    {
        return $this->query;
    }

    public function request(): ParametersBag
    {
        return $this->request;
    }

    public function files(): ParametersBag
    {
        return $this->files;
    }

    public function server(): ParametersBag
    {
        return $this->server;
    }

    public function getMethod(): string
    {
        return $this->server->get('REQUEST_METHOD');
    }
}
