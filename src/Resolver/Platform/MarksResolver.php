<?php

declare(strict_types=1);

namespace App\Resolver\Platform;

use App\DTO\Platform\MarksDTO;
use App\Entity\Platform\Course;
use App\Entity\Platform\CourseStudent;
use App\Entity\Platform\Solution;
use App\Entity\UserManagement\User;
use App\Filter\CourseStudent\CourseStudentFilterGenerator;
use App\Repository\Platform\CourseStudentRepository;
use App\Repository\Platform\ExerciseRepository;
use App\Repository\Platform\SolutionRepository;
use App\Service\Pagination\Paginator;
use Symfony\Component\Security\Core\Security;

class MarksResolver
{
    public function __construct(
        private readonly CourseStudentFilterGenerator $courseStudentFilterGenerator,
        private readonly ExerciseRepository $exerciseRepository,
        private readonly SolutionRepository $solutionRepository,
    ) {
    }

    public function resolve(?Paginator $paginator = null, ?array $filterData = []): array
    {
        $coursesForStudent = $this->courseStudentFilterGenerator
            ->setData($filterData)
            ->setPaginator($paginator)
            ->findResults();

        $output = [];
        /** @var CourseStudent $courseStudent */
        foreach ($coursesForStudent as $courseStudent) {
            $course = $courseStudent->getCourse();
            $output[] = (new MarksDTO())
                ->setCourseId($course->getId())
                ->setStudentId($courseStudent?->getStudent()?->getId())
                ->setCourseName($course->getName())
                ->setLeadingTeacher($course->getLeadingTeacher()->getFullname())
                ->setStatus($course->getStatus())
                ->setStudent($courseStudent?->getStudent()?->getFullName())
                ->setMark($courseStudent->getMarksDictionary()?->getImportance() ?? null)
                ->setComponentMark($this->getComponentMark($courseStudent->getCourse(), $courseStudent->getStudent()));
        }

        return $output;
    }

    private function getComponentMark(Course $course, User $student): float
    {
        $exercises = $this->exerciseRepository->findBy(['course' => $course]);
        $exerciseSum = count($exercises);
        $markSum = 0;

        foreach ($exercises as $exercise) {
            /** @var Solution $solution */
            $solution = $this->solutionRepository->findOneBy(['exercise' => $exercise, 'student' => $student]);
            $mark = $solution?->getMarksDictionary()?->getImportance() ?? 0;
            $markSum += $mark;
        }

        if ($exerciseSum === 0) {
            return 0;
        }

        return round($markSum / $exerciseSum, 2);
    }
}
