<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Repository\Interfaces\EntityRepositoryInterface;

class Paginator
{
    /**
     * @param EntityRepositoryInterface $entityRepository
     * @param array<string,mixed> $criteria
     * @param int $limit
     * @param int $pageData
     * @param array<string,string> $order
     * @return object[]|null
     */
    public function paginate(EntityRepositoryInterface $entityRepository, array $criteria, int $limit, int $pageData, array $order = ["created_at" => "DESC"]): ?array
    {
        /** @var array<int,object> $entities */
        $entities = $entityRepository->findBy($criteria, true, $order, $limit, $limit * ($pageData - 1));
        if ($entities) {
            return $entities;
        }
        return null;
    }

    public function getMaxPage(int $nbEntity, int $limitPerPage): int
    {
        if ($limitPerPage === 0 || $nbEntity == 0) {
            return 1;
        }
        return (int)ceil($nbEntity / $limitPerPage);
    }

    public function isExistingPage(int $pageData, int $maxPage): bool
    {
        if ($pageData <= 0 || $pageData > $maxPage) {
            return false;
        }
        return true;
    }
}
