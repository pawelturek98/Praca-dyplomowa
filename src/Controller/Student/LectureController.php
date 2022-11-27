<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Entity\Platform\Lecture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    #[Route('student/course/lecture/{id}/show', name: 'app.student.course.lecture.show')]
    public function show(Lecture $lecture): Response
    {
        return $this->render('student/lecture/show.html.twig', [
            'lecture' => $lecture
        ]);
    }
}
