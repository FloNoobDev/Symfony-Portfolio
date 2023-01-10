<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\SkillRepository;
use App\Repository\ProfilRepository;
use App\Repository\ContactRepository;
use App\Repository\SkillCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageHomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProfilRepository $profilRepository, SkillCategoryRepository $skillCategoryRepository, SkillRepository $skillRepository, ContactRepository $contactRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'skillsCategories' => $skillCategoryRepository->findAll(),
            // 'production' => '',
            'formContact' => $this->createForm(ContactType::class, new Contact()),
            'profil' => $profilRepository->find(1)
        ]);
    }
}