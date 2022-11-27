<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Entity\UserManagement\Address;
use App\Entity\UserManagement\User;
use App\Form\UserManagement\AddressFormType;
use App\Form\UserManagement\PasswordFormType;
use App\Form\UserManagement\RegistrationFormType;
use App\FormHandler\UserManagement\UserFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserSettingsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[Route('/user-settings', name: 'app.common.user_settings')]
    public function index(
        Request $request,
        UserFormHandler $userFormHandler,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $address = $user->getAddress() ?? new Address();

        $userFormHandler->setAddress($address);
        $userFormHandler->setUser($user);

        $addressForm = $this->createForm(AddressFormType::class, $address);
        $addressForm->handleRequest($request);

        if ($userFormHandler->handleAddressForm($addressForm)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.address_data_changed');
            return $this->redirectToRoute('app.common.user_settings');
        }

        $userForm = $this->createForm(RegistrationFormType::class, $user);
        $userForm->handleRequest($request);

        if($userFormHandler->handleUserForm($userForm)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.user_info_changed');
            return $this->redirectToRoute('app.common.user_settings');
        }

        $passwordForm = $this->createForm(PasswordFormType::class);
        $passwordForm->handleRequest($request);

        if ($this->handlePasswordForm($passwordForm, $user)) {
            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.user_password_changed');
            return $this->redirectToRoute('app.common.user_settings');
        }

        return $this->render('common/user-settings.html.twig', [
            'user' => $user,
            'address' => $address,
            'addressForm' => $addressForm->createView(),
            'userForm' => $userForm->createView(),
            'passwordForm' => $passwordForm->createView(),
        ]);
    }

    public function handlePasswordForm(FormInterface $form, User $user): bool
    {
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }

        $oldPassword = $form->get('oldPassword')->getViewData();
        $hashedOldPassword = $this->passwordHasher->hashPassword($user, $oldPassword);
        $password = $form->get('password')->getViewData();
        $passwordRepeated = $form->get('passwordRepeat')->getViewData();
        if ($hashedOldPassword !== $user->getPassword()) {
            $this->addFlash(FlashTypeDictionary::ERROR, 'app.flash_messages.old_password_not_same');
            return false;
        }

        if ($password !== $passwordRepeated) {
            $this->addFlash(FlashTypeDictionary::ERROR, 'app.flash_messages.password_not_same');
            return false;
        }

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $password)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
}
