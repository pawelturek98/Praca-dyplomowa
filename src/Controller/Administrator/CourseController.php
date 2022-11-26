<?php

declare(strict_types=1);

namespace App\Controller\Administrator;

use App\Factory\Pagination\PaginatorFactory;
use App\Filter\Course\CourseFilterGenerator;
use App\Filter\Course\CourseFilterResolver;
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
        $filterData = [];

        $courses = $courseFilterGenerator
            ->setData($filterData)
            ->setPaginator($paginator)
            ->findResults();

        $total = $courseFilterGenerator->setData($filterData)->countResults();

        return $this->render('administrator/course/list.html.twig', [
            'courses' => $courses,
        ]);
    }
}