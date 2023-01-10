<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjectCategoryController extends AbstractController
{
    #[Route('/admin/project/category', name: 'admin_project_category')]
    public function index(): Response
    {
        return $this->render('admin/admin_project_category/index.html.twig', [
            'controller_name' => 'AdminProjectCategoryController',
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

}
