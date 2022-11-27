<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Platform\Course;
use App\Entity\Platform\CourseStudent;
use App\Entity\UserManagement\User;
use App\Factory\Pagination\PaginatorFactory;
use App\Filter\CourseStudent\CourseStudentFilterResolver;
use App\Form\Dictionary\MarkFormType;
use App\Form\Platform\Filter\MarkFilterFormType;
use App\Repository\Dictionary\MarksDictionaryRepository;
use App\Repository\Platform\CourseStudentRepository;
use App\Resolver\Platform\ExerciseResolver;
use App\Resolver\Platform\MarksResolver;
use App\Service\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
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
        PaginatorFactory $paginatorFactory,
    ): Response {
        $paginator = $paginatorFactory->createFromRequest($request);
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

    #[Route('teacher/marks/{courseId}/{studentId}/show', name: 'app.teacher.marks.show')]
    public function show(
        string $courseId,
        string $studentId,
        Request $request,
        ExerciseResolver $exerciseResolver,
        CourseStudentRepository $courseStudentRepository,
        MarksDictionaryRepository $marksDictionaryRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        /** @var CourseStudent $courseStudent */
        $courseStudent = $courseStudentRepository->findOneBy(['course' => $courseId, 'student' => $studentId]);
        $markForm = $this->createForm(MarkFormType::class);
        $markForm->handleRequest($request);

        if ($markForm->isSubmitted() && $markForm->isValid()) {
            $mark = $marksDictionaryRepository->find($markForm->get('mark')->getViewData());
            $courseStudent->setMarksDictionary($mark);

            $entityManager->persist($courseStudent);
            $entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.student_marked');
            return $this->redirectToRoute('app.teacher.marks.show', ['courseId' => $courseId, 'studentId' => $studentId]);
        }

        $exercises = $exerciseResolver->resolve($courseStudent->getCourse(), $courseStudent->getStudent());

        return $this->render('teacher/mark/show.html.twig', [
            'courseStudent' => $courseStudent,
            'exercises' => $exercises,
            'markForm' => $markForm->createView(),
        ]);
    }
}
