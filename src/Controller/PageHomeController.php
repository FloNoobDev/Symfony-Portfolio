<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ProfilRepository;
use App\Repository\SkillCategoryRepository;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageHomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProfilRepository $profilRepository, SkillCategoryRepository $skillCategoryRepository, ProjectCategoryRepository $projectCategoryRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'profil' => $profilRepository->find(1),
            'projectsCats' => $projectCategoryRepository->findAll(),
            'skillsCategories' => $skillCategoryRepository->findAll(),
            'formContact' => $this->createForm(ContactType::class, new Contact()),
        ]);
    }
}