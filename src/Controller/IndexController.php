<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\SetupRepository;
use App\Repository\SkillRepository;
use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillCategoryRepository;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'index')]
class IndexController extends AbstractController
{
    private SkillCategoryRepository $skillCatRepo;
    private SkillRepository $skillRepo;
    private ProjectCategoryRepository $projectCatRepo;
    private ProjectRepository $projectRepo;
    private ProfilRepository $profilRepository;
    private SetupRepository $setupRepository;


    public function __construct(
         SkillCategoryRepository $skillCatRepo,
         SkillRepository $skillRepo,
         ProjectCategoryRepository $projectCatRepo,
         ProjectRepository $projectRepo,
         ProfilRepository $profilRepository,
         SetupRepository $setupRepository,
    ){
        $this->skillCatRepo = $skillCatRepo;
        $this->skillRepo= $skillRepo;
        $this->projectCatRepo= $projectCatRepo;
        $this->projectRepo= $projectRepo;
        $this->profilRepository = $profilRepository;
        $this->setupRepository = $setupRepository;
    }

    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'profile' => $this->profilRepository->find(['id' => $this->setupRepository->findOneBy(['name'=>'showProfile'])->getValue()]),
            'projectsCats' => $this->projectCatRepo->findAll(),
            'skillsCategories' => $this->skillCatRepo->findAll(),
            'formContact' => $this->createForm(ContactType::class, new Contact()),
        ]);
    }

    #[Route('/admin', name: '-admin')]
    public function indexAdmin(): Response
    {
        return $this->render('home/indexAdmin.html.twig', [
            'projectCatCount' => count($this->projectCatRepo->findAll()),
            'projectCount' => count($this->projectRepo->findAll()),
            'skillCatCount' => count($this->skillCatRepo->findAll()),
            'skillCount' => count($this->skillRepo->findAll()),
        ]);
    }
}