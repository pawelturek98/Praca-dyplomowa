<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Platform\Course;
use App\Entity\Platform\Exercise;
use App\Form\Platform\ExerciseFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teacher/course/')]
class ExerciseController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('{id}/exercise/add', name: 'app.teacher.course.exercise.add')]
    public function create(
        Course $course,
        Request $request,
    ): Response {
        $exercise = new Exercise();
        $exerciseForm = $this->createForm(ExerciseFormType::class, $exercise);
        $exerciseForm->handleRequest($request);

        if ($this->handleExerciseForm($exerciseForm, $exercise, $course)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.exercise_created');
            return $this->redirectToRoute('app.teacher.course.show', ['id' => $course->getId()]);
        }

        return $this->render('teacher/exercise/create.html.twig', [
            'exerciseForm' => $exerciseForm
        ]);
    }

    #[Route('{id}/exercise/edit', name: 'app.teacher.course.exercise.edit')]
    public function edit(
        Exercise $exercise,
        Request $request,
    ): Response {
        $exerciseForm = $this->createForm(ExerciseFormType::class, $exercise);
        $exerciseForm->handleRequest($request);

        if ($this->handleExerciseForm($exerciseForm, $exercise)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.exercise_edited');
            return $this->redirectToRoute('app.teacher.course.exercise.edit', ['id' => $exercise->getId()]);
        }

        return $this->render('teacher/exercise/edit.html.twig', [
            'exerciseForm' => $exerciseForm
        ]);
    }

    #[Route('{id}/exercise/delete', name: 'app.teacher.course.exercise.delete')]
    public function delete(
        Exercise $exercise,
        string $courseId
    ): Response {
        $this->entityManager->remove($exercise);
        $this->entityManager->flush();

        return $this->redirectToRoute('app.teacher.course.show', ['id' => $courseId]);
    }

    private function handleExerciseForm(FormInterface $form, Exercise $exercise, ?Course $course = null): bool
    {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        if ($course) {
            $exercise->setCourse($course);
        } else {
            $exercise->setUpdatedAt(new DateTime('now'));
        }

        $this->entityManager->persist($exercise);
        $this->entityManager->flush();

        return true;
    }
}
