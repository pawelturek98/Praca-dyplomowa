<?php

declare(strict_types=1);

namespace App\Filter\UserManagement;

use App\Filter\UserManagement\Filters\UserFilterInterface;

class UserFilterResolver
{
    private ?array $data = [];

    public function __construct(
        private readonly iterable $userFilter
    ) {
    }

    public function resolve(?array $filterData): ?array
    {
        /** @var UserFilterInterface $filter */
        foreach ($this->userFilter as $filter) {
            $key = $filter::NAME;
            if (isset($filterData[$key])) {
                $data = $filterData[$key];

                if ($filter->support([$key => $data])) {
                    $this->data[$key] = $data;
                }
            }
        }

        return $this->data;
    }
}
