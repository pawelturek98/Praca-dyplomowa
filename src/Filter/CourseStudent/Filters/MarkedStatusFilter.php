<?php

declare(strict_types=1);

namespace App\Filter\CourseStudent\Filters;

use App\Dictionary\Platform\StatusDictionary;
use Doctrine\ORM\QueryBuilder;

class MarkedStatusFilter implements CourseStudentFilterInterface
{
    public const NAME = 'markedStatus';

    public function support(array $data): bool
    {
        return isset($data[self::NAME]) && !empty($data[self::NAME]);
    }

    public function modifyQueryBuilder(QueryBuilder $queryBuilder, array $data): void
    {
        $isMarkedStatus = $data[self::NAME] === StatusDictionary::STATUS_MARKED;
        if ($isMarkedStatus) {
            $queryBuilder->andWhere('cs.marksDictionary is not null');
        } else {
            $queryBuilder->andWhere('cs.marksDictionary is null');
        }
    }
}
