<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\Message\Answer;
use App\Entity\Message\Message;
use App\Factory\Pagination\PaginatorFactory;
use App\Form\Message\AnswerFormType;
use App\Form\Message\MessageFormType;
use App\Repository\Message\AnswerRepository;
use App\Repository\Message\MessageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('common/messages', name: 'app.common.messages')]
    public function index(
        Request $request,
        MessageRepository $messageRepository,
        PaginatorFactory $paginatorFactory,
    ): Response {
        $paginator = $paginatorFactory->createFromRequest($request);
        $messages = $messageRepository->findAllPaginatedForUser($paginator, $this->getUser());

        return $this->render('common/message/index.html.twig', [
            'messages' => $messages,
            'paginator' => $paginator,
        ]);
    }

    #[Route('common/messages/sent', name: 'app.common.messages.sent')]
    public function sent(
        Request $request,
        MessageRepository $messageRepository,
        PaginatorFactory $paginatorFactory,
    ): Response {
        $paginator = $paginatorFactory->createFromRequest($request);
        $messages = $messageRepository->findAllPaginatedForSender($paginator, $this->getUser());

        return $this->render('common/message/sent.html.twig', [
            'messages' => $messages,
            'paginator' => $paginator,
        ]);
    }

    #[Route('common/messages/create', name: 'app.common.messages.create')]
    public function create(
        Request $request,
    ): Response {
        $message = new Message();
        $messageForm = $this->createForm(MessageFormType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $message->setSender($this->getUser());

            $this->entityManager->persist($message);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.message_sent');
            return $this->redirectToRoute('app.common.messages.show', ['id' => $message->getId()]);
        }

        return $this->render('common/message/create.html.twig', [
            'messageForm' => $messageForm->createView()
        ]);
    }

    #[Route('common/messages/{id}/show', name: 'app.common.messages.show')]
    public function show(
        Message $message,
        Request $request,
        AnswerRepository $answerRepository,
        PaginatorFactory $paginatorFactory,
    ): Response {
        $answer = new Answer();
        $answerForm = $this->createForm(AnswerFormType::class, $answer);
        $answerForm->handleRequest($request);

        if ($message->getReceiver() === $this->getUser()) {
            $message->setIsSeen(true);
            $message->setSeenAt(new DateTime('now'));

            $this->entityManager->persist($message);
            $this->entityManager->flush();
        }

        if ($answerForm->isSubmitted() && $answerForm->isValid()) {
            $answer->setParent($message);
            $answer->setSender($this->getUser());

            $message->setIsSeen(false);

            $this->entityManager->persist($answer);
            $this->entityManager->persist($message);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.message_sent');
            return $this->redirectToRoute('app.common.messages.show', ['id' => $message->getId()]);
        }

        $paginator = $paginatorFactory->createFromRequest($request);
        $answers = $answerRepository->findAllPaginatedForMessage($paginator, $message);

        return $this->render('common/message/show.html.twig', [
            'message' => $message,
            'answerForm' => $answerForm->createView(),
            'answers' => $answers,
            'paginator' => $paginator,
        ]);
    }
}
