<?php

declare(strict_types=1);

namespace App\Service\Http;

use App\Service\XssValidator;

final class Request
{
    private readonly ParametersBag $query; // $_GET
    private readonly ParametersBag $request; // $_POST
    private readonly ParametersBag $files; // $_FILES
    private readonly ParametersBag $server; // $_SERVER



    /**
     * @param array<mixed> $query
     * @param array<mixed> $request
     * @param array<mixed> $files
     * @param array<mixed> $server
     */
    public function __construct(array $query, array $request, array $files, array $server)
    {
        $xssValidator = new XssValidator();
        $protectedQuery = $xssValidator->handleProtectionXSS($query);
        $protectedRequest = $xssValidator->handleProtectionXSS($request);
        $protectedFile = $xssValidator->handleProtectionXSS($files);
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
