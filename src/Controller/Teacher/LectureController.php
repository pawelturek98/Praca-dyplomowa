<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Platform\Course;
use App\Entity\Platform\Lecture;
use App\Form\Platform\LectureFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/teacher/course/{id}/lecture/add', name: 'app.teacher.course.lecture.add')]
    public function create(Course $course, Request $request): Response
    {
        $lecture = new Lecture();
        $lectureForm = $this->createForm(LectureFormType::class, $lecture);
        $lectureForm->handleRequest($request);

        if ($lectureForm->isSubmitted() && $lectureForm->isValid()) {
            $lecture->setCourse($course);

            $this->entityManager->persist($lectureForm);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.lecture_created');
            return $this->redirectToRoute('app.teacher.course.show', ['id' => $course->getId()]);
        }

        return $this->render('teacher/lecture/create.html.twig', [
           'lectureForm' => $lectureForm->createView()
        ]);
    }

    public function edit()
    {

    }

}