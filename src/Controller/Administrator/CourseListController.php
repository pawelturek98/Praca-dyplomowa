<?php

declare(strict_types=1);

namespace App\Controller\Administrator;

use App\Repository\Platform\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseListController extends AbstractController
{
    public function __construct(
        private readonly CourseRepository $courseRepository,
    ) {
    }

    #[Route('administrator/course/list', name: 'app.administrator.course.list')]
    public function index(): Response
    {
        $courses = $this->courseRepository->findAll();

        return $this->render('administrator/course/list.html.twig', [
            'courses' => $courses
        ]);
    }
}
