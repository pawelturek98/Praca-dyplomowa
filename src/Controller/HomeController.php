<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dictionary\UserManagement\UserDictionary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app.home')]
    public function index(): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('app.security.login');
        }
        $userRole = current($this->getUser()->getRoles());
        $role = UserDictionary::POSSIBLE_ROLES[$userRole];

        return $this->redirectToRoute(
            sprintf('app.%s.course.list', $role)
        );
    }
}

