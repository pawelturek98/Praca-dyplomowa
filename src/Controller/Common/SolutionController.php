<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Entity\Files\SolutionAttachment;
use App\Enum\Storage\FileTypeEnum;
use App\Resolver\Storage\FilePathResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class SolutionController extends AbstractController
{
    #[Route('/common/course/exercise/solution/attachment/{id}/download', name: 'app.common.solution.attachment.download')]
    public function downloadSolutionAttachment(
        SolutionAttachment $solutionAttachment,
        FilePathResolver $filePathResolver,
    ): Response {
        $storage = $solutionAttachment->getStorage();

        $path = $filePathResolver->resolve(FileTypeEnum::SolutionAttachment);

        $response = new BinaryFileResponse(sprintf('%s/%s', $path, $storage->getName()));
        $response->headers->set('Content-Type', $storage->getType());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }
}
