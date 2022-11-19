<?php

declare(strict_types=1);

namespace App\Resolver\Platform;

use App\Entity\Platform\Exercise;
use App\Entity\Platform\Solution;
use App\Factory\Platform\SolutionFactory;
use Symfony\Component\Security\Core\User\UserInterface;

class SolutionResolver
{
    public function __construct(
        private readonly SolutionFactory $solutionFactory
    ) {
    }

    public function resolve(?Solution $solution, UserInterface $student, Exercise $exercise): Solution
    {
        if (null !== $solution) {
            return $solution;
        }

        return $this->solutionFactory->create($student, $exercise);
    }
}
