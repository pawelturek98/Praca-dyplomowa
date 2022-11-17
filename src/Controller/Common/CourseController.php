<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Forum\Forum;
use App\Entity\Platform\Course;
use App\Entity\Platform\CourseStudent;
use App\Form\Forum\ForumFormType;
use App\Form\Platform\CourseFormType;
use App\Form\Platform\CourseStudentFormType;
use App\Repository\Forum\ForumRepository;
use App\Repository\Platform\CourseStudentRepository;
use App\Repository\Platform\ExerciseRepository;
use App\Repository\Platform\LectureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('common/course/')]
class CourseController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('{id}/show/{slug}/{forumId}', name: 'app.common.course.show')]
    public function show(
        Course $course,
        Request $request,
        LectureRepository $lectureRepository,
        ExerciseRepository $exerciseRepository,
        CourseStudentRepository $courseStudentRepository,
        ForumRepository $forumRepository,
        string $slug = 'course-show',
        string $forumId = null,
    ): Response {
        $courseForm = $this->createForm(CourseFormType::class, $course);
        $courseForm->handleRequest($request);

        if ($this->handleCourseForm($courseForm, $course)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.course_edited');
            return $this->redirectToRoute('app.teacher.course.show', ['id' => $course->getId()]);
        }

        $lectures = $lectureRepository->findBy(['course' => $course]);
        $exercises = $exerciseRepository->findBy(['course' => $course]);
        $courseStudents = $courseStudentRepository->findBy(['course' => $course]);
        $forumList = $forumRepository->findBy(['course' => $course]);

        $courseStudent = new CourseStudent();
        $courseStudentForm = $this->createForm(CourseStudentFormType::class, $courseStudent);
        $courseStudentForm->handleRequest($request);

        if ($this->handleCourseStudentForm($courseStudentForm, $courseStudent, $course)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.course_student_added');
            return $this->redirectToRoute('app.common.course.show', ['id' => $course->getId()]);
        }

        $forumForm = $this->createForm(ForumFormType::class, new Forum());

        return $this->render('common/course/show.html.twig', [
            'course' => $course,
            'courseForm' => $courseForm->createView(),
            'lectures' => $lectures,
            'exercises' => $exercises,
            'courseStudents' => $courseStudents,
            'courseStudentForm' => $courseStudentForm->createView(),
            'forumList' => $forumList,
            'forumForm' => $forumForm->createView(),
            'slug' => $slug,
            'forumId' => $forumId,
        ]);
    }

    private function handleCourseForm(
        FormInterface $form,
        Course $course
    ): bool {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        $this->entityManager->persist($course);
        $this->entityManager->flush();

        return true;
    }

    private function handleCourseStudentForm(
        FormInterface $form,
        CourseStudent $courseStudent,
        Course $course
    ): bool {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        $courseStudent->setCourse($course);

        $this->entityManager->persist($courseStudent);
        $this->entityManager->flush();

        return true;
    }
}