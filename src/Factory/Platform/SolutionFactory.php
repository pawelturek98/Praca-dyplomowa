<?php

declare(strict_types=1);

namespace App\Factory\Platform;

use App\Entity\Platform\Exercise;
use App\Entity\Platform\Solution;
use Symfony\Component\Security\Core\User\UserInterface;

class SolutionFactory
{
    public function create(UserInterface $student, Exercise $exercise): Solution
    {
        return (new Solution())
            ->setStudent($student)
            ->setExercise($exercise);
    }
}
