<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkillController extends AbstractController
{
    #[Route('/admin/skill', name: 'app_admin_skill')]
    public function index(): Response
    {
        return $this->render('admin/admin_skill/index.html.twig', [
            'controller_name' => 'AdminSkillController',
        ]);
    }
}
