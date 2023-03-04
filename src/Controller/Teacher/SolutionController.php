<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Platform\Solution;
use App\Form\Dictionary\MarkFormType;
use App\Repository\Dictionary\MarksDictionaryRepository;
use App\Repository\Files\SolutionAttachmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SolutionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('teacher/course/solution/{id}/show', name: 'app.teacher.course.solution.show')]
    public function show(
        Solution $solution,
        Request $request,
        SolutionAttachmentsRepository $solutionAttachmentsRepository,
        MarksDictionaryRepository $marksDictionaryRepository,
    ): Response {
        $markForm = $this->createForm(MarkFormType::class);
        $markForm->handleRequest($request);

        if ($markForm->isSubmitted() && $markForm->isValid()) {
            $mark = $marksDictionaryRepository->find($markForm->get('mark')->getViewData());
            $solution->setMarksDictionary($mark);
            $this->entityManager->persist($solution);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.solution_marked');
            return $this->redirectToRoute('app.teacher.course.solution.show', ['id' => $solution->getId()]);
        }

        $solutionAttachments = $solutionAttachmentsRepository->findBy(['solution' => $solution]);

        return $this->render('teacher/exercise/solution/show.html.twig', [
            'markForm' => $markForm->createView(),
            'solution' => $solution,
            'solutionFiles' => $solutionAttachments
        ]);
    }
}
