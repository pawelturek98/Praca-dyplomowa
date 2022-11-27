<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Entity\Platform\Course;
use App\Filter\CourseStudent\Filters\StudentFilter;
use App\Form\Dictionary\MarkFormType;
use App\Resolver\Platform\ExerciseResolver;
use App\Resolver\Platform\MarksResolver;
use App\Service\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarksController extends AbstractController
{
    #[Route('student/marks/', name: 'app.student.marks')]
    public function index(
        MarksResolver $marksResolver,
        Request $request,
    ): Response {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', 30);
        $paginator = new Paginator($page, $pageLimit);
        $filterData = [];
        $filterData[StudentFilter::NAME] = $this->getUser()->getId();

        return $this->render('student/mark/index.html.twig', [
            'marks' => $marksResolver->resolve($paginator, $filterData)
        ]);
    }

    #[Route('student/marks/{id}/show', name: 'app.student.marks.show')]
    public function show(
        Course $course,
        ExerciseResolver $exerciseResolver,
    ): Response {
        $exercises = $exerciseResolver->resolve($course, $this->getUser());

        return $this->render('student/mark/show.html.twig', [
            'exercises' => $exercises,
            'course' => $course,
        ]);
    }
}
