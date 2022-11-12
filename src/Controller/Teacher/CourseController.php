<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Platform\Course;
use App\Filter\Course\CourseFilterGenerator;
use App\Filter\Course\Filters\TeacherFilter;
use App\Form\Platform\CourseFormType;
use App\Form\Platform\Filter\CourseFilterFormType;
use App\Repository\Platform\CourseStudentRepository;
use App\Repository\Platform\ExerciseRepository;
use App\Repository\Platform\LectureRepository;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teacher/course/')]
class CourseController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('list', name: 'app.teacher.course.list')]
    public function list(
        Request $request,
        CourseFilterGenerator $courseFilterGenerator
    ): Response {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', 100);
        $paginator = new Paginator($page, $pageLimit);

        $filterForm = $this->createForm(CourseFilterFormType::class);

        $filterData[TeacherFilter::NAME] = $this->getUser()->getId();
        if (null !== $request->get('filter')) {
            $filterData = $request->get('filter');
        }

        $courses = $courseFilterGenerator
            ->setData($filterData)
            ->setPaginator($paginator)
            ->findResults();

        $allCoursesAmount = $courseFilterGenerator->setData($filterData)->countResults();

        return $this->render('teacher/course/list.html.twig', [
            'courses' => $courses,
            'total' => $allCoursesAmount,
            'paginator' => $paginator,
            'filterForm' => $filterForm->createView()
        ]);
    }

    #[Route('add', name: 'app.teacher.course.add')]
    public function create(
        Request $request
    ): Response {
        $course = new Course();
        $courseForm = $this->createForm(CourseFormType::class, $course);
        $courseForm->handleRequest($request);

        if ($courseForm->isSubmitted() && $courseForm->isValid()) {
            $course->setLeadingTeacher($this->getUser());

            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }

        return $this->render('teacher/course/create.html.twig', [
            'courseForm' => $courseForm->createView()
        ]);
    }

    #[Route('{id}/show', name: 'app.teacher.course.show')]
    public function show(
        Course $course,
        Request $request,
        LectureRepository $lectureRepository,
        ExerciseRepository $exerciseRepository,
        CourseStudentRepository $courseStudentRepository,
    ): Response {
        $courseForm = $this->createForm(CourseFormType::class, $course);
        $courseForm->handleRequest($request);

        if ($courseForm->isSubmitted() && $courseForm->isValid()) {
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }

        $lectures = $lectureRepository->findBy(['course' => $course]);
        $exercises = $exerciseRepository->findBy(['course' => $course]);
        $courseStudent = $courseStudentRepository->findBy(['course' => $course]);

        return $this->render('teacher/course/show.html.twig', [
            'course' => $course,
            'courseForm' => $courseForm->createView(),
            'lectures' => $lectures,
            'exercises' => $exercises,
            'courseStudent' => $courseStudent,
        ]);
    }

    #[Route('{id}/delete', name: 'app.teacher.course.delete')]
    public function delete(Course $course): Response
    {
        if ($course->getLeadingTeacher() !== $this->getUser()) {
            $this->addFlash(FlashTypeDictionary::ERROR, 'app.course.delete.error');
            return $this->redirectToRoute('app.teacher.course.list');
        }

        $this->entityManager->remove($course);
        $this->entityManager->flush();
        $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.course.delete.success');

        return $this->redirectToRoute('app.teacher.course.list');
    }
}
