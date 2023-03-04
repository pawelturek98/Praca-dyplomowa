<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Entity\Platform\Lecture;
use App\Enum\Storage\FileTypeEnum;
use App\Resolver\Storage\FilePathResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LectureController extends AbstractController
{
    public function __construct(
        private readonly FilePathResolver $filePathResolver
    ) {
    }

    #[Route('common/course/lecture/{id}/downloadFile', name: 'app.common.course.lecture.download_file')]
    public function downloadLectureFile(Lecture $lecture): Response
    {
        return $this->getFileResponse($lecture, ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }

    #[Route('common/course/lecture/{id}/showPDF', name: 'app.common.course.lecture.show_pdf')]
    public function showPDF(Lecture $lecture): Response
    {
        if (!str_contains($lecture->getLectureFile()?->getType(), 'pdf')) {
            return new Response();
        }

        return $this->getFileResponse($lecture, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    private function getFileResponse(Lecture $lecture, string $disposition): Response
    {
        if (!$lecture->getLectureFile()) {
            throw new NotFoundHttpException();
        }

        $storage = $lecture->getLectureFile();
        $response = new BinaryFileResponse(
            sprintf('%s/%s', $this->filePathResolver->resolve(FileTypeEnum::LectureAttachment), $storage->getName())
        );

        $response->headers->set('Content-Type', $storage->getType());
        $response->setContentDisposition($disposition);

        return $response;
    }
}
