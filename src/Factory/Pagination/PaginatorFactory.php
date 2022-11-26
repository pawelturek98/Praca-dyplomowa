<?php

declare(strict_types=1);

namespace App\Factory\Pagination;

use App\Service\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class PaginatorFactory
{
    public const PAGE_LIMIT = 30;

    public function createFromRequest(Request $request): Paginator
    {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', self::PAGE_LIMIT);

        return new Paginator($page, $pageLimit);
    }
}
