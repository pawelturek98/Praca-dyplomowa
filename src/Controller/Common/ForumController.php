<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\Forum\Forum;
use App\Entity\Forum\ForumPost;
use App\Entity\Platform\Course;
use App\Entity\UserManagement\User;
use App\Form\Forum\ForumFormType;
use App\Form\Forum\ForumPostFormType;
use App\Repository\Forum\ForumPostRepository;
use App\Repository\Forum\ForumRepository;
use App\Repository\Platform\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ForumRepository $forumRepository,
        private readonly ForumPostRepository $forumPostRepository,
    ) {
    }

    public function posts(
        string $forumId
    ): Response {
        $postForm = $this->createForm(ForumPostFormType::class);

        /** @var Forum $forum */
        $forum = $this->forumRepository->find($forumId);

        if (!$forum) {
            throw new NotFoundHttpException();
        }

        $posts = $this->forumPostRepository->findBy(['forum' => $forum]);

        return $this->render('common/forum/posts.html.twig', [
            'forum' => $forum,
            'posts' => $posts,
            'course' => $forum->getCourse(),
            'postForm' => $postForm->createView(),
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

        $endpoint = 'app.student.course.show';
        if ($this->getUser()->getType() === UserDictionary::ROLE_TEACHER) {
            $endpoint = 'app.teacher.course.show';
        }

        if ($forumForm->isSubmitted() && $forumForm->isValid()) {
            $forum->setAuthor($this->getUser());
            $forum->setCourse($course);

            $this->entityManager->persist($forum);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.forum_created');
            return $this->redirectToRoute($endpoint, [
                'id' => $course->getId(),
                'slug' => 'forum',
                'forumId' => $forum->getId()
            ]);
        }

        throw new BadRequestException();
    }

    #[Route('common/course/{courseId}/forum/{id}/post/create', name: 'app.common.course.forum.post_create')]
    public function createPost(
        Forum $forum,
        string $courseId,
        Request $request,
    ): Response {
        if ($forum->isClosed()) {
            $this->addFlash(FlashTypeDictionary::WARNING, 'app.flash_messages.forum_is_closed');

            return $this->redirectToRoute('app.common.course.show', [
                'id' => $courseId,
                'slug' => $forum,
                'forumId' => $forum->getId()
            ]);
        }

        $post = new ForumPost();
        $postForm = $this->createForm(ForumPostFormType::class, $post);
        $postForm->handleRequest($request);

        if ($postForm->isSubmitted() && $postForm->isValid()) {
            $post->setAuthor($this->getUser());
            $post->setForum($forum);

            $this->entityManager->persist($post);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.post_created');
            return $this->redirectToRoute('app.common.course.show', [
                'id' => $courseId,
                'slug' => 'forum',
                'forumId' => $forum->getId()
            ]);
        }

        throw new BadRequestException();
    }
}
