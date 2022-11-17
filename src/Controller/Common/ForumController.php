<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Forum\Forum;
use App\Entity\Platform\Course;
use App\Entity\UserManagement\User;
use App\Form\Forum\ForumFormType;
use App\Repository\Forum\ForumPostRepository;
use App\Repository\Forum\ForumRepository;
use App\Repository\Platform\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('common/course/forum/{id}/posts', name: 'app.common.course.forum.posts')]
    public function posts(
        Forum $forum,
        ForumPostRepository $forumPostRepository,
    ): Response {
        $posts = $forumPostRepository->findBy(['forum' => $forum]);

        return $this->render('common/forum/posts.html.twig', [
            'forum' => $forum,
            'posts' => $posts,
        ]);
    }

    #[Route('common/course/{id}/forum/create', name: 'app.common.course.forum.create')]
    public function createForum(
        Course $course,
        Request $request
    ): Response {
        $forum = new Forum();
        $forumForm = $this->createForm(ForumFormType::class, $forum);
        $forumForm->handleRequest($request);

        if ($forumForm->isSubmitted() && $forumForm->isValid()) {
            $forum->setAuthor($this->getUser());
            $forum->setCourse($course);

            $this->entityManager->persist($forum);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.forum_created');
            return $this->redirectToRoute('app.common.course.forum.posts', [
                'courseId' => $course->getId(),
                'id' => $forum->getId()
            ]);
        }

        throw new BadRequestException();
    }

    public function handlePostCreate(FormInterface $form, Forum $forum, User $user)
    {

    }
}
