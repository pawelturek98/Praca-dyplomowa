<?php

declare(strict_types=1);

namespace App\Controller\Administrator;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\UserManagement\User;
use App\Form\UserManagement\UserAdministrationFormType;
use App\Repository\UserManagement\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserManagementController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('administration/user/list', name: 'app.administrator.user.list')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('administrator/user/list.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('administration/user/create', name: 'app.administrator.user.create')]
    public function create(
        Request $request,
    ): Response {
        $user = new User();
        $userAdministrationForm = $this->createForm(UserAdministrationFormType::class, $user);
        $userAdministrationForm->handleRequest($request);

        if ($userAdministrationForm->isSubmitted() && $userAdministrationForm->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.user_created');
            return $this->redirectToRoute('app.administrator.user.edit', ['id' => $user->getId()]);
        }

        return $this->render('administrator/user/create.html.twig', [
            'userForm' => $userAdministrationForm->createView(),
        ]);
    }

    #[Route('administrator/user/{id}/edit', name: 'app.administrator.user.edit')]
    public function edit(
        User $user,
        Request $request,
    ): Response {
        $userAdministrationForm = $this->createForm(UserAdministrationFormType::class, $user);
        $userAdministrationForm->handleRequest($request);

        if ($userAdministrationForm->isSubmitted() && $userAdministrationForm->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.user_edited');
            return $this->redirectToRoute('app.administrator.user.edit', ['id' => $user->getId()]);
        }

        return $this->render('administrator/user/edit.html.twig', [
            'userForm' => $userAdministrationForm->createView()
        ]);
    }
}
