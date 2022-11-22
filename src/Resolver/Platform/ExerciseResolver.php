<?php

declare(strict_types=1);

namespace App\Resolver\Platform;

use App\DTO\Platform\ExerciseDTO;
use App\Entity\Platform\Course;
use App\Entity\Platform\Exercise;
use App\Entity\Platform\Solution;
use App\Entity\UserManagement\User;
use App\Repository\Platform\ExerciseRepository;
use App\Repository\Platform\SolutionRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ExerciseResolver
{
    public function __construct(
        private readonly SolutionRepository $solutionRepository,
        private readonly ExerciseRepository $exerciseRepository,
        private readonly Security $security,
    ) {
    }

    public function resolve(Course $course = null, ?UserInterface $student = null): array
    {
        $exercises = $this->exerciseRepository->findBy(['course' => $course]);
        $output = [];

        if (null === $student) {
            $student = $this->security->getUser();
        }

        /** @var Exercise $exercise $exercise */
        foreach ($exercises as $exercise) {
            /** @var Solution $solution */
            $solution = $this->solutionRepository->findOneBy([
                'exercise' => $exercise,
                'student' => $student,
            ]);

            $mark = null;
            $isDisposed = false;
            $disposedAt = null;

            if ($solution) {
                $mark = $solution->getMarksDictionary()?->getName();
                $isDisposed = $solution->isSaved();
                $disposedAt = $solution->getDisposedAt();
            }

            $output[] = (new ExerciseDTO())
                ->setId($exercise->getId())
                ->setName($exercise->getExerciseName())
                ->setCourse($course)
                ->setClosedAt($exercise->getCreatedAt())
                ->setCreatedAt($exercise->getCreatedAt())
                ->setDisposedAt($disposedAt)
                ->setMark($mark)
                ->setDisposed($isDisposed);
        }

        return $output;
    }
}
