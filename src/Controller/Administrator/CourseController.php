<?php

declare(strict_types=1);

namespace App\Controller\Administrator;

use App\Factory\Pagination\PaginatorFactory;
use App\Filter\Course\CourseFilterGenerator;
use App\Filter\Course\CourseFilterResolver;
use App\Filter\CourseStudent\Filters\CourseFilter;
use App\Form\Platform\Filter\CourseFilterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('administrator/course/list', name: 'app.administrator.course.list')]
    public function index(
        Request $request,
        PaginatorFactory $paginatorFactory,
        CourseFilterGenerator $courseFilterGenerator,
        CourseFilterResolver $courseFilterResolver,
    ): Response {
        $paginator = $paginatorFactory->createFromRequest($request);
        $filterForm = $this->createForm(CourseFilterFormType::class);
        $filterData = [];

        if ($request->get($filterForm->getName())) {
            $filterData = $courseFilterResolver->resolve(
                $request->get($filterForm->getName())
            );
        }

        $courses = $courseFilterGenerator
            ->setData($filterData)
            ->setPaginator($paginator)
            ->findResults();

        $total = $courseFilterGenerator->setData($filterData)->countResults();

        return $this->render('administrator/course/list.html.twig', [
            'courses' => $courses,
            'paginator' => $paginator,
            'filterForm' => $filterForm->createView(),
            'filterData' => $filterData,
            'lastPage' => ceil($total / $paginator->pageLimit),
        ]);
    }
}
