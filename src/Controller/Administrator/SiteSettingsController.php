<?php

declare(strict_types=1);

namespace App\Controller\Administrator;

use App\Dictionary\Main\FlashTypeDictionary;
use App\Form\Page\SiteSettingsFormType;
use App\Resolver\Page\SiteSettingsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteSettingsController extends AbstractController
{
    #[Route('/site/settings', name: 'app.administrator.site.settings')]
    public function index(
        Request $request,
        SiteSettingsResolver $settingsResolver,
        EntityManagerInterface $entityManager,
    ): Response {
        $settings = $settingsResolver->resolve();
        $settingsForm = $this->createForm(SiteSettingsFormType::class, $settings);
        $settingsForm->handleRequest($request);

        if ($settingsForm->isSubmitted() && $settingsForm->isValid()) {
            $entityManager->persist($settings);
            $entityManager->flush();

            $this->addFlash(FlashTypeDictionary::SUCCESS, 'app.flash_messages.site_settings_saved');
            return $this->redirectToRoute('app.administrator.site.settings');
        }

        return $this->render('administrator/site/settings.html.twig', [
            'settingsForm' => $settingsForm->createView(),
            'settings' => $settings,
        ]);
    }
}
