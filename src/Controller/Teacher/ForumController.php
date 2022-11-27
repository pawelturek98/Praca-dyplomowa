<?php

declare(strict_types=1);

namespace App\Controller\Teacher;

use App\Entity\Forum\Forum;
use App\Entity\Forum\ForumPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('teacher/forum/{id}/change-status', name: 'app.teacher.forum.change_status')]
    public function changeStatus(
        Forum $forum
    ): Response {
        if ($forum->getCourse()->getLeadingTeacher() !== $this->getUser()) {
            throw new NotFoundHttpException();
        }

        $forum->setIsClosed(!$forum->isClosed());
        $this->entityManager->persist($forum);
        $this->entityManager->flush();

        return $this->redirectToRoute('app.common.course.show', [
            'id' => $forum->getCourse()->getId(),
            'slug' => 'forum',
        ]);
    }

    #[Route('teacher/forum/post/{id}/delete', name: 'app.teacher.forum.post.delete')]
    public function deletePost(
        ForumPost $forumPost
    ): Response {
        $forum = $forumPost->getForum();
        if ($forum->getCourse()->getLeadingTeacher() !== $this->getUser()) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($forumPost);
        $this->entityManager->flush();
        return $this->redirectToRoute('app.common.course.show', [
            'id' => $forum->getCourse()->getId(),
            'slug' => 'forum',
            'forumId' => $forum->getId()
        ]);
    }
}
