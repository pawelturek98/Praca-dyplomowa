<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Entity\Platform\Course;
use App\Filter\CourseStudent\CourseStudentFilterGenerator;
use App\Filter\CourseStudent\Filters\StudentFilter;
use App\Form\Platform\Filter\CourseFilterFormType;
use App\Service\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('student/courses/list', name: 'app.student.course.list')]
    public function list(
        Request $request,
        CourseStudentFilterGenerator $courseStudentFilterGenerator
    ): Response {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', 1);
        $paginator = new Paginator($page, $pageLimit);
        $filterForm = $this->createForm(CourseFilterFormType::class);

        if (null !== $request->get('filter')) {
            $filterData = $request->get('filter');
        }
        $filterData[StudentFilter::NAME] = $this->getUser()->getId();

        $courses = $courseStudentFilterGenerator
            ->setPaginator($paginator)
            ->setData($filterData)
            ->findResults();

        $allCoursesAmount = $courseStudentFilterGenerator->setData($filterData)->countResults();

        return $this->render('student/course/list.html.twig', [
            'filterForm' => $filterForm->createView(),
            'courses' => $courses,
            'total' => $allCoursesAmount,
            'paginator' => $paginator,
            'pageLimit' => $pageLimit,
            'lastPage' => ceil($allCoursesAmount / $pageLimit),
            'currentPage' => $page,
        ]);
    }
}
