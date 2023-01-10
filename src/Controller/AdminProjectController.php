<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectController extends AbstractController
{
    #[Route('/admin/project', name: 'admin_project')]
    public function index(): Response
    {
        return $this->render('admin/admin_project/index.html.twig', [
            'controller_name' => 'AdminProjectController',
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