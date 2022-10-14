<?php

declare(strict_types=1);

namespace App\Service;

class XssValidator
{
    /**
     * @param array<string,mixed> $parameters
     * @return array<string,mixed>
     */
    public function handleProtectionXSS(array &$parameters): array
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
}
