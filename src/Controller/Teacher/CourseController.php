<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Filter\Course\CourseFilterGenerator;
use App\Filter\Course\Filters\TeacherFilter;
use App\Service\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/teacher/course/list', name: 'app.teacher.course.list')]
    public function list(
        Request $request,
        CourseFilterGenerator $courseFilterGenerator
    ) {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', 100);
        $paginator = new Paginator($page, $pageLimit);

        $filterData[TeacherFilter::NAME] = $this->getUser();
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
            'paginator' => $paginator
        ]);
    }

    public function create(
        Request $request
    ) {

    }

    public function edit(
        Request $request
    ) {

    }

    public function delete(
        Request $request
    ) {

    }
}
