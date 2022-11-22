<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Dictionary\Platform\StatusDictionary;
use App\Entity\Platform\Course;
use App\Entity\Platform\CourseStudent;
use App\Filter\Course\CourseFilterGenerator;
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
        CourseFilterGenerator $courseFilterGenerator
    ): Response {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', 30);
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
            'filterForm' => $filterForm->createView(),
            'pageLimit' => $pageLimit,
            'lastPage' => ceil($allCoursesAmount / $pageLimit),
            'currentPage' => $page,
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
