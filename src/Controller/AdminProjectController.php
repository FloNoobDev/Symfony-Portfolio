<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectController extends AbstractController
{
    #[Route('/admin/projects', name: 'admin_project')]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/admin_project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

   

    #[Route('/admin/create-proj', name: 'create_proj')]
    public function createProj(): Response
    {
        return $this->render('admin/project/createProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/update-proj', name: 'update_proj')]
    public function updateProj(): Response
    {
        return $this->render('admin/project/updateProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/delete-proj', name: 'delete_proj')]
    public function deleteProj(): Response
    {
        return $this->render('admin/project/deleteProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
