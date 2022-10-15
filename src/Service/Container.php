<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;

class Container
{
    /**
     * @var array<string,mixed>
     */
    private array $instanceData;

    /**
     * @var array<string,mixed>
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
        foreach ($this->instanceData as $key => $value) {
            $className = $key;
            $attributes = [];
            if ($key === Request::class) {
                $this->instanceList[XssValidator::class]->handleProtectionXSS($query);
                $this->instanceList[XssValidator::class]->handleProtectionXSS($request);
                $this->instanceList[XssValidator::class]->handleProtectionXSS($files);
                $attributes = [...[$query, $request, $files, $server]];
            }
            // Instantiation dataHandler
            foreach ($value["attributes"]["dataHandler"] as $attribute) {
                if ($attribute === Container::class) {
                    $attributes[] = $this;
                    continue;
                }

                $attributes[] = $this->instanceList[$attribute];
            }
            // Instantiation environments variables
            foreach ($value["attributes"]["environmentVariable"] as $attribute) {
                $attributes[] = $this->instanceList[Environment::class]->get($attribute);
            }
            // Instantiation services
            foreach ($value["attributes"]["services"] as $attribute) {
                if ($attribute === Environment::class) {
                    $attributes[] = $this->instanceList[Environment::class]->all();
                    continue;
                }
                $attributes[] = $this->instanceList[$attribute];
            }
            $this->instanceList[$key] = $this->createInstance($className, $attributes);
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
            return call_user_func_array(
                array(
                    new ReflectionClass($className), 'newInstance'),
                $arguments
            );
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
