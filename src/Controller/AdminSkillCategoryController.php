<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkillCategoryController extends AbstractController
{
    #[Route('/admin/skill-category', name: 'admin_skill_category')]
    public function index(): Response
    {
        return $this->render('admin/admin_skill_category/index.html.twig', [
            'controller_name' => 'AdminSkillCategoryController',
        ]);
    }
}
