<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Dictionary\FileUploader\FileUploaderStrategyDictionary;
use App\Dictionary\Main\FlashTypeDictionary;
use App\Dictionary\Platform\LectureTypeDictionary;
use App\Entity\Files\Storage;
use App\Entity\Platform\Course;
use App\Entity\Platform\Lecture;
use App\Factory\Storage\StorageFactory;
use App\Form\Platform\LectureFormType;
use App\Repository\Platform\CourseRepository;
use App\Service\Uploader\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teacher/course/')]
class LectureController extends AbstractController
{
    private const TARGET_DIRECTORY = '/uploaded/lecture';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Uploader $uploader,
        private readonly StorageFactory $storageFactory,
    ) {
    }

    #[Route('{id}/lecture/add', name: 'app.teacher.course.lecture.add')]
    public function create(Course $course, Request $request): Response
    {
        $lecture = new Lecture();
        $lectureForm = $this->createForm(LectureFormType::class, $lecture);
        $lectureForm->handleRequest($request);

        $formHandled = $this->handleForm(
            form: $lectureForm,
            lecture: $lecture,
            course: $course
        );

        if ($formHandled) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.lecture_created');
            return $this->redirectToRoute('app.teacher.course.show', ['id' => $course->getId()]);
        }

        return $this->render('teacher/lecture/create.html.twig', [
            'lectureForm' => $lectureForm->createView(),
            'course' => $course,
        ]);
    }

    #[Route('{id}/{courseId}/lecture/edit', name: 'app.teacher.course.lecture.edit')]
    public function edit(
        Lecture $lecture,
        string $courseId,
        Request $request,
        CourseRepository $courseRepository
    ): Response {
        $lectureForm = $this->createForm(LectureFormType::class, $lecture);
        $lectureForm->handleRequest($request);
        $formHandled = $this->handleForm($lectureForm, $lecture);

        if($formHandled) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.lecture_edited');
            return $this->redirectToRoute('app.teacher.course.lecture.edit', ['id' => $lecture->getId()]);
        }

        $course = $courseRepository->find($courseId);

        return $this->render('teacher/lecture/edit.html.twig', [
            'lectureForm' => $lectureForm->createView(),
            'lecture' => $lecture,
            'course' => $course,
        ]);
    }

    #[Route('{id}/lecture/delete', name: 'app.teacher.course.lecture.delete')]
    public function delete(Lecture $lecture): Response {
        $course = $lecture->getCourse();
        if ($course->getLeadingTeacher() !== $this->getUser()) {
            $this->addFlash(FlashTypeDictionary::ERROR, 'app.flash_messages.lecture_delete_error');
            return $this->redirectToRoute('app.teacher.course.show', ['id' => $course->getId()]);
        }

        $this->entityManager->remove($lecture);
        $this->entityManager->flush();

        return $this->redirectToRoute('app.teacher.course.show', ['id' => $course->getId()]);
    }

    private function handleForm(FormInterface $form, Lecture $lecture, ?Course $course = null): bool
    {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        if ($course) {
            $lecture->setCourse($course);
        }

        if ($lecture->getType() === LectureTypeDictionary::PDF_TYPE) {
            $pdfFile = $form->get('contentFile')->getData();
            $lecture->setLectureFile(
                $this->handlePdfFile($pdfFile)
            );
        }

        $this->entityManager->persist($lecture);
        $this->entityManager->flush();

        return true;
    }

    private function handlePdfFile(?UploadedFile $pdfFile): ?Storage
    {
        if (!$pdfFile) {
            return null;
        }

        $filename = $this->uploader
            ->setFile($pdfFile)
            ->setStrategy(FileUploaderStrategyDictionary::STRATEGY_LOCAL)
            ->setTargetDirectory(self::TARGET_DIRECTORY)
            ->upload();

        return $this->storageFactory->create($filename, $this->getUser());
    }
}
