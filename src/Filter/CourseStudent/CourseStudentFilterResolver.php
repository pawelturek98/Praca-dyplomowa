<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent;

use App\Filter\CourseStudent\Filters\CourseStudentFilterInterface;

class CourseStudentFilterResolver
{
    private ?array $data = [];

    public function __construct(
        private readonly iterable $courseFilter
    ) {
    }

    public function resolve(?array $filterData): ?array
    {
        /** @var CourseStudentFilterInterface $filter */
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
