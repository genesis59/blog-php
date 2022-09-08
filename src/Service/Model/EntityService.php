<?php

declare(strict_types=1);

namespace App\Service\Model;

use App\Model\Repository\Interfaces\EntityRepositoryInterface;

abstract class EntityService
{
    public function __construct(private readonly EntityRepositoryInterface $entityRepository)
    {
    }

    public function getMaxPage(int $limitPerPage): int
    {
        if ($limitPerPage === 0) {
            return 1;
        }
        return (int)ceil($this->entityRepository->count() / $limitPerPage);
    }

    public function getCurrentPage(int $pageData, int $nbPageMax): int
    {
        if ($pageData <= 0 || $pageData > $nbPageMax) {
            $pageData = 1;
        }
        return $pageData;
    }
}
