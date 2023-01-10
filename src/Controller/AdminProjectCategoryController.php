<?php

namespace App\Controller;

use App\Entity\ProjectCategory;
use App\Form\ProjectCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminProjectCategoryController extends AbstractController
{

    #[Route('/admin/project-category', name: 'project_categories')]
    public function index(ProjectCategoryRepository $projectCategoryRepository): Response
    {
        return $this->render('admin/admin_project_category/index.html.twig', [
            'projectCats' => $projectCategoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/create-proj-cat', name: 'create_projcat')]
    public function createProjCat(Request $request,ManagerRegistry $managerRegistry): Response
    {
        $projectCat = new ProjectCategory();
        $form = $this->createForm(ProjectCategoryType::class, $projectCat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($projectCat);
            $manager->flush();

            return $this->redirectToRoute('project_categories');
        }

        return $this->render('admin/admin_project_category/createProjectCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/update-proj-cat/{id}', name: 'update_projcat')]
    public function updateProjCat(): Response
    {
        return $this->render('admin/admin_project_category/updateProjectCategory.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/delete-proj-cat/{id}', name: 'delete_projcat')]
    public function deleteProjCat(): Response
    {
        return $this->render('admin/admin_project_category/deleteProjectCategory.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
