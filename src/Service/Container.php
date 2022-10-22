<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Request;
use ReflectionClass;
use ReflectionNamedType;
use Symfony\Component\Yaml\Yaml;
use Whoops\Exception\ErrorException;

class Container
{
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
        $this->instanceList[Environment::class] = new Environment();
        $instanceData = Yaml::parseFile($this->instanceList[Environment::class]->get("CONFIG_CONTAINER"));

        foreach ($instanceData as $className) {
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
            // on ne veut pas rechercher les attributs de la classe Request
            // on les passe directement à la variable $arguments de createInstance
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
        $this->instantiate($query, $request, $files, $server);
    }

    /**
     * @param string $className
     * @return object
     * @throws ErrorException
     */
    public function get(string $className): object
    {
        $instance = $this->has($className) ? $this->instanceList[$className] : null;
        if (!$instance instanceof $className) {
            throw new ErrorException("Avez-vous oubliez dans le fichier container.yaml: {$className}");
        }
        return $instance;
    }

    /**
     * @param string $className
     * @return bool
     */
    public function has(string $className): bool
    {
        return isset($this->instanceList[$className]);
    }
}
