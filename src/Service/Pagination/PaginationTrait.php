<?php

declare(strict_types=1);

namespace App\Service\Pagination;

trait PaginationTrait
{
    public function getMaxPage(int $nbEntity, int $limitPerPage): int
    {
        if ($limitPerPage === 0) {
            return 1;
        }
        return (int)ceil($nbEntity / $limitPerPage);
    }

    public function getCurrentPage(int $pageData, int $nbPageMax): int
    {
        if ($pageData <= 0 || $pageData > $nbPageMax) {
            $pageData = 1;
        }
        return $pageData;
    }
}
