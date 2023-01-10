<?php

namespace App\Controller;

use App\Repository\SkillCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkillCategoryController extends AbstractController
{
    #[Route('/admin/skill-category', name: 'admin_skill_category')]
    public function index(SkillCategoryRepository $skillCategoryRepository): Response
    {
        return $this->render('admin/admin_skill_category/index.html.twig', [
            'skillCats' => $skillCategoryRepository->findAll(),
        ]);
    }
}
