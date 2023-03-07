<?php

namespace App\Controller\Admin;

use App\Repository\ProjectCategoryRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillCategoryRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminIndexController extends AbstractController
{
    private SkillCategoryRepository $skillCatRepo;
    private SkillRepository $skillRepo;
    private ProjectCategoryRepository $projectCatRepo;
    private ProjectRepository $projectRepo;

    public function __construct(
         SkillCategoryRepository $skillCatRepo,
         SkillRepository $skillRepo,
         ProjectCategoryRepository $projectCatRepo,
         ProjectRepository $projectRepo,
    ){
        $this->skillCatRepo = $skillCatRepo;
        $this->skillRepo= $skillRepo;
        $this->projectCatRepo= $projectCatRepo;
        $this->projectRepo= $projectRepo;
    }

    #[Route('/admin', name: 'index-admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'projectCatCount' => count($this->projectCatRepo->findAll()),
            'projectCount' => count($this->projectRepo->findAll()),
            'skillCatCount' => count($this->skillCatRepo->findAll()),
            'skillCount' => count($this->skillRepo->findAll()),
        ]);
    }

}