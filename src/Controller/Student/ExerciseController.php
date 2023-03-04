<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Dictionary\FileUploader\FileUploaderStrategyDictionary;
use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Files\SolutionAttachment;
use App\Entity\Platform\Exercise;
use App\Entity\Platform\Solution;
use App\Enum\Storage\FileTypeEnum;
use App\Factory\Storage\StorageFactory;
use App\Form\Storage\StorageFormType;
use App\Repository\Files\SolutionAttachmentsRepository;
use App\Repository\Files\StorageRepository;
use App\Repository\Platform\SolutionRepository;
use App\Resolver\Platform\SolutionResolver;
use App\Resolver\Storage\FilePathResolver;
use App\Service\Uploader\Uploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('student/course/exercise/{id}/show', name: 'app.student.course.exercise.show')]
    public function show(
        Exercise $exercise,
        Request $request,
        SolutionRepository $solutionRepository,
        SolutionAttachmentsRepository $solutionAttachmentsRepository,
        SolutionResolver $solutionResolver,
        StorageFactory $storageFactory,
        Uploader $uploader,
        FilePathResolver $filePathResolver,
    ): Response {
        $solution = $solutionRepository->findOneBy(['exercise' => $exercise, 'student' => $this->getUser()]);
        $solutionFiles = $solutionAttachmentsRepository->findBy(['solution' => $solution]);
        $solutionFile = new SolutionAttachment();
        $solutionForm = $this->createForm(StorageFormType::class, $solutionFile);
        $solutionForm->handleRequest($request);

        if ($solutionForm->isSubmitted() && $solutionForm->isValid()) {
            $solution = $solutionResolver->resolve($solution, $this->getUser(), $exercise);
            $this->entityManager->persist($solution);

            $file = $solutionForm->get('file')->getViewData();
            $filename = $uploader
                ->setStrategy(FileUploaderStrategyDictionary::STRATEGY_LOCAL)
                ->setTargetDirectory($filePathResolver->resolve(FileTypeEnum::SolutionAttachment))
                ->setFile($file)
                ->upload();

            $storage = $storageFactory->create($filename, $this->getUser());
            $this->entityManager->persist($storage);

            $solutionFile
                ->setSolution($solution)
                ->setStorage($storage);

            $this->entityManager->persist($solutionFile);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.added_solution_attachment');
            return $this->redirectToRoute('app.student.course.exercise.show', ['id' => $exercise->getId()]);
        }

        return $this->render('student/exercise/show.html.twig', [
            'exercise' => $exercise,
            'solution' => $solution,
            'solutionFiles' => $solutionFiles,
            'solutionForm' => $solutionForm->createView(),
        ]);
    }

    #[Route('student/course/solution/{id}/dispose', 'app.student.course.solution.dispose')]
    public function dispose(Solution $solution): Response
    {
        if ($solution->getStudent() !== $this->getUser()) {
            throw new NotFoundHttpException();
        }

        $solution->setDisposedAt($solution->isSaved() ? null : new DateTime('now'));
        $solution->setIsSaved(!$solution->isSaved());

        $this->entityManager->persist($solution);
        $this->entityManager->flush();

        $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.solution_disposed');
        return $this->redirectToRoute('app.student.course.exercise.show', [
            'id' => $solution->getExercise()->getId()
        ]);
    }

    #[Route('student/course/solution/attachment/{id}/delete', 'app.student.course.solution.delete_file')]
    public function deleteFile(SolutionAttachment $solutionAttachment): Response
    {
        $solution = $solutionAttachment->getSolution();
        if ($solution->getStudent() !== $this->getUser()) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($solutionAttachment);
        $this->entityManager->flush();

        $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.solution_attachment_remove');
        return $this->redirectToRoute('app.student.course.exercise.show', [
            'id' => $solution->getExercise()->getId(),
        ]);
    }
}
