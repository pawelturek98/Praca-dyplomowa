<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Dictionary\Platform\StatusDictionary;
use App\Entity\Platform\Course;
use App\Entity\Platform\CourseStudent;
use App\Factory\Pagination\PaginatorFactory;
use App\Filter\Course\CourseFilterGenerator;
use App\Filter\Course\CourseFilterResolver;
use App\Filter\Course\Filters\TeacherFilter;
use App\Form\Platform\CourseFormType;
use App\Form\Platform\Filter\CourseFilterFormType;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
        CourseFilterGenerator $courseFilterGenerator,
        CourseFilterResolver $courseFilterResolver,
        PaginatorFactory $paginatorFactory,
    ): Response {
        $paginator = $paginatorFactory->createFromRequest($request);

        $filterForm = $this->createForm(CourseFilterFormType::class);

        if ($request->get($filterForm->getName())) {
            $filterData = $courseFilterResolver->resolve(
                $request->get($filterForm->getName())
            );
        }
        $filterData[TeacherFilter::NAME] = $this->getUser()->getId();

        $courses = $courseFilterGenerator
            ->setData($filterData)
            ->setPaginator($paginator)
            ->findResults();

        $allCoursesAmount = $courseFilterGenerator->setData($filterData)->countResults();

        return $this->render('teacher/course/list.html.twig', [
            'courses' => $courses,
            'paginator' => $paginator,
            'filterForm' => $filterForm->createView(),
            'filterData' => $filterData,
            'lastPage' => ceil($allCoursesAmount / $paginator->currentPage),
        ]);
    }

    #[Route('add', name: 'app.teacher.course.add')]
    public function create(
        Request $request
    ): Response {
        $course = new Course();
        $courseForm = $this->createForm(CourseFormType::class, $course);
        $courseForm->handleRequest($request);

        if ($this->handleCourseForm($courseForm, $course, $this->getUser())) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.course_created');
            return $this->redirectToRoute('app.teacher.course.list', );
        }

        return $this->render('teacher/course/create.html.twig', [
            'courseForm' => $courseForm->createView()
        ]);
    }

    #[Route('{id}/delete', name: 'app.teacher.course.delete')]
    public function delete(Course $course): Response
    {
        if ($course->getLeadingTeacher() !== $this->getUser()) {
            $this->addFlash(FlashTypeDictionary::ERROR, 'app.flash_messages.course_delete_error');
            return $this->redirectToRoute('app.teacher.course.list');
        }

        $course->setStatus(StatusDictionary::STATUS_DELETED);

        $this->entityManager->flush();
        $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.course_deleted');

        return $this->redirectToRoute('app.teacher.course.list');
    }

    #[Route('{id}/course-student/delete', name: 'app.teacher.course_student.delete')]
    public function deleteCourseStudent(CourseStudent $courseStudent): Response
    {
        $course = $courseStudent->getCourse();
        $this->entityManager->remove($courseStudent);
        $this->entityManager->flush();

        $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.course_student_removed');
        return $this->redirectToRoute('app.common.course.show', [
            'id' => $course->getId(),
            'slug' => 'student-list'
        ]);
    }

    private function handleCourseForm(
        FormInterface $form,
        Course $course,
        ?UserInterface $leadingTeacher,
    ): bool {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        $course->setLeadingTeacher($leadingTeacher);

        $this->entityManager->persist($course);
        $this->entityManager->flush();

        return true;
    }
}
