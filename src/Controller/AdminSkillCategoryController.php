<?php

namespace App\Controller;

use App\Entity\SkillCategory;
use App\Form\ProjectCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SkillCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSkillCategoryController extends AbstractController
{
    public function __construct(private ProjectCategoryType $projectCategoryType,private ManagerRegistry $managerRegistry)
    {
        
    }
    
    #[Route('/admin/skill-category', name: 'skill_categories')]
    public function index(SkillCategoryRepository $skillCategoryRepository): Response
    {
        return $this->render('admin/admin_skill_category/index.html.twig', [
            'skillCats' => $skillCategoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/skill-category', name: 'create_skill_category')]
    public function create(Request $request): Response
    {
        $projectCat = new SkillCategory();
        $form = $this->createForm(SkillCategoryType::class,$projectCat);
        $form->handleRequest($request);



       
        return $this->render('admin/admin_skill_category/createSkillCat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/skill-category-update/{id}', name: 'update_skill_category')]
    public function update(): Response
    {
        return $this->render('admin/admin_skill_category/index.html.twig', [
        ]);
    }
    #[Route('/admin/skill-category-delete/{id}', name: 'delete_skill_category')]
    public function delete(): Response
    {
        return $this->render('admin/admin_skill_category/index.html.twig', [
        ]);
    }
}
