<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Entity\Platform\Course;
use App\Factory\Pagination\PaginatorFactory;
use App\Filter\CourseStudent\CourseStudentFilterGenerator;
use App\Filter\CourseStudent\CourseStudentFilterResolver;
use App\Filter\CourseStudent\Filters\StudentFilter;
use App\Form\Platform\Filter\CourseFilterFormType;
use App\Form\Platform\Filter\CourseStudentFilterFormType;
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
        CourseStudentFilterGenerator $courseStudentFilterGenerator,
        CourseStudentFilterResolver $courseStudentFilterResolver,
        PaginatorFactory $paginatorFactory,
    ): Response {
        $paginator = $paginatorFactory->createFromRequest($request);
        $filterForm = $this->createForm(CourseStudentFilterFormType::class);

        if ($request->get($filterForm->getName())) {
            $filterData = $courseStudentFilterResolver->resolve(
                $request->get($filterForm->getName())
            );
        }

        $filterData[StudentFilter::NAME] = $this->getUser()->getId();

        $courses = $courseStudentFilterGenerator
            ->setPaginator($paginator)
            ->setData($filterData)
            ->findResults();

        $allCoursesAmount = $courseStudentFilterGenerator->setData($filterData)->countResults();

        return $this->render('student/course/list.html.twig', [
            'filterForm' => $filterForm->createView(),
            'filterData' => $filterData,
            'courses' => $courses,
            'paginator' => $paginator,
            'lastPage' => ceil($allCoursesAmount / $paginator->pageLimit),
        ]);
    }
}
