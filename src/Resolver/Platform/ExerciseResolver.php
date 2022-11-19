<?php

declare(strict_types=1);

namespace App\Resolver\Platform;

use App\DTO\Platform\ExerciseDTO;
use App\Entity\Platform\Course;
use App\Entity\Platform\Exercise;
use App\Entity\Platform\Solution;
use App\Repository\Platform\ExerciseRepository;
use App\Repository\Platform\SolutionRepository;
use Symfony\Component\Security\Core\Security;

class ExerciseResolver
{
    public function __construct(
        private readonly SolutionRepository $solutionRepository,
        private readonly ExerciseRepository $exerciseRepository,
        private readonly Security $security,
    ) {
    }

    public function resolve(Course $course): array
    {
        $exercises = $this->exerciseRepository->findBy(['course' => $course]);
        $output = [];

        /** @var Exercise $exercise $exercise */
        foreach ($exercises as $exercise) {
            /** @var Solution $solution */
            $solution = $this->solutionRepository->findOneBy([
                'exercise' => $exercise,
                'student' => $this->security->getUser()
            ]);

            $mark = null;
            $isDisposed = false;

            if ($solution) {
                $mark = $solution->getMarksDictionary()?->getName();
                $isDisposed = $solution->isSaved();
            }

            $output[] = (new ExerciseDTO())
                ->setId($exercise->getId())
                ->setName($exercise->getExerciseName())
                ->setCourse($course)
                ->setClosedAt($exercise->getCreatedAt())
                ->setCreatedAt($exercise->getCreatedAt())
                ->setMark($mark)
                ->setDisposed($isDisposed);
        }

        return $output;
    }
}
