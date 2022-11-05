<?php

declare(strict_types=1);

namespace App\Service\Pagination;

class Paginator
{
    public readonly int $offset;
    public function __construct(
        public readonly int $currentPage,
        public readonly int $pageLimit
    ) {
        $this->offset = ($this->currentPage - 1) * $this->pageLimit;
    }
}
