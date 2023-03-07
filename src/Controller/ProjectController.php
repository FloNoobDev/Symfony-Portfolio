<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\ProjectCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/project', name: 'project')]
class ProjectController extends AbstractController
{
    private ProjectCategoryRepository $projectCategoryRepository;
    private ProjectRepository $projectRepository;
    private ManagerRegistry $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(
        ProjectCategoryRepository $projectCategoryRepository,
        ProjectRepository $projectRepository,
        ManagerRegistry $managerRegistry,
        SluggerInterface $slugger,
    ) {
        $this->projectCategoryRepository = $projectCategoryRepository;
        $this->projectRepository = $projectRepository;
        $this->managerRegistry = $managerRegistry;
        $this->slugger = $slugger;
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('admin/admin_project/index.html.twig', [
            'projects' => $this->projectRepository->findAll(),
            'form' =>$form->createView(),
        ]);
    }

    #[Route('-admin/update', name: '-admin-update')]
    public function update(): Response
    {
        return $this->render('admin/project/updateProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('-admin/delete', name: '-admin-delete')]
    public function delete(): Response
    {
        return $this->render('admin/project/deleteProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
