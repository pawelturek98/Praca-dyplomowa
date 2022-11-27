<?php

declare(strict_types=1);

namespace App\Filter\Course;

use App\Filter\Course\Filters\CourseFilterInterface;

class CourseFilterResolver
{
    private ?array $data = [];

    public function __construct(
        private readonly iterable $courseFilter
    ) {
    }

    public function resolve(?array $filterData): ?array
    {
        /** @var CourseFilterInterface $filter */
        foreach ($this->courseFilter as $filter) {
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