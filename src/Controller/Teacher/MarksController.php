<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Entity\Platform\Course;
use App\Entity\UserManagement\User;
use App\Filter\CourseStudent\CourseStudentFilterResolver;
use App\Form\Dictionary\MarkFormType;
use App\Form\Platform\Filter\MarkFilterFormType;
use App\Resolver\Platform\ExerciseResolver;
use App\Resolver\Platform\MarksResolver;
use App\Service\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarksController extends AbstractController
{
    #[Route('teacher/marks/', name: 'app.teacher.marks')]
    public function index(
        MarksResolver $marksResolver,
        Request $request,
        CourseStudentFilterResolver $courseStudentFilterResolver,
    ): Response {
        $page = (int) $request->get('page', 1);
        $pageLimit = (int) $request->get('pageLimit', 30);
        $paginator = new Paginator($page, $pageLimit);
        $filterForm = $this->createForm(MarkFilterFormType::class);

        $filterData = [];
        if ($request->get($filterForm->getName())) {
            $filterData = $courseStudentFilterResolver->resolve($request->get($filterForm->getName()));
        }

        return $this->render('teacher/mark/index.html.twig', [
            'marks' => $marksResolver->resolve($paginator, $filterData),
            'filterForm' => $filterForm->createView(),
            'filterData' => $filterData,
        ]);
    }

    #[Route('teacher/marks/{id}/show', name: 'app.teacher.marks.show')]
    public function show(
        Course $course,
        Request $request,
        ExerciseResolver $exerciseResolver,
    ): Response {
        $exercises = $exerciseResolver->resolve($course, $this->getUser());

        $markForm = $this->createForm(MarkFormType::class);
        $markForm->handleRequest($request);

        return $this->render('student/mark/show.html.twig', [
            'exercises' => $exercises,
            'course' => $course,
            'markForm' => $markForm->createView(),
        ]);
    }
}
