<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use ReflectionClass;
use ReflectionNamedType;
use Symfony\Component\Yaml\Yaml;

class Container
{
    /**
     * @var array<string,mixed>
     */
    private array $instanceData;

    /**
     * @var array<int|string,mixed>
     */
    private array $instanceList = [];

    /**
     * @param array<mixed> $query
     * @param array<mixed> $request
     * @param array<mixed> $files
     * @param array<mixed> $server
     * @return void
     */
    private function instantiate(array $query, array $request, array $files, array $server): void
    {
        $this->instanceList[Container::class] = $this;
        foreach ($this->instanceData as $className) {
            if ($className === Request::class) {
                $this->instanceList[XssValidator::class]->handleProtectionXSS($query);
                $this->instanceList[XssValidator::class]->handleProtectionXSS($request);
                $this->instanceList[XssValidator::class]->handleProtectionXSS($files);
                $this->instanceList[$className] = $this->createInstance($className, [...[$query, $request, $files, $server]]);
                continue;
            }
            $this->instanceList[$className] = $this->createInstance($className);
        }
    }

    /**
     * @param string $className
     * @param array<int,mixed> $arguments
     * @return false|mixed
     */
    private function createInstance(string $className, array $arguments = array()): mixed
    {
        if (class_exists($className)) {
            if ($className === Request::class) {
                return call_user_func_array(array(new ReflectionClass($className), 'newInstance'), $arguments);
            }
            // On récupère les objets à passer au constructeur à l'aide de ReflectionClass
            $clone = new ReflectionClass($className);
            if ($clone->getConstructor() && count($clone->getConstructor()->getParameters()) > 0) {
                foreach ($clone->getConstructor()->getParameters() as $parameter) {
                    if ($parameter->getType() instanceof ReflectionNamedType) {
                        $arguments[] = $this->instanceList[$parameter->getType()->getName()];
                    }
                }
            }
            return call_user_func_array(array($clone, 'newInstance'), $arguments);
        }
        return false;
    }

    /**
     * @param array<mixed> $query
     * @param array<mixed> $request
     * @param array<mixed> $files
     * @param array<mixed> $server
     */
    public function __construct(array $query, array $request, array $files, array $server)
    {
        $this->instanceData = Yaml::parseFile("./../config/container.yaml");
        $this->instantiate($query, $request, $files, $server);
    }

    /**
     * @param string $className
     * @return object
     */
    public function get(string $className): object
    {
        $instance = $this->has($className) ? $this->instanceList[$className] : null;
        if ($instance instanceof $className) {
            return $instance;
        }
        $this->instanceData[Session::class]->addFlashes("danger", "Désolé nous rencontrons un problème.");
        exit();
    }

    /**
     * @param string $className
     * @return bool
     */
    public function has(string $className): bool
    {
        return (bool)$this->instanceList[$className];
    }
}
