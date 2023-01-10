<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectController extends AbstractController
{
    #[Route('/admin/project', name: 'app_admin_project')]
    public function index(): Response
    {
        return $this->render('admin_project/index.html.twig', [
            'controller_name' => 'AdminProjectController',
        ]);
    }

    #[Route('/admin/create-proj-cat', name: 'create_projcat')]
    public function createProjCat(): Response
    {
        return $this->render('admin/project/createProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/update-proj-cat', name: 'update_projcat')]
    public function updateProjCat(): Response
    {
        return $this->render('admin/project/updateProject.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/delete-proj-cat', name: 'delete_projcat')]
    public function deleteProjCat(): Response
    {
        return $this->render('admin/project/deleteProject.html.twig', [
            'controller_name' => 'AdminController',
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
