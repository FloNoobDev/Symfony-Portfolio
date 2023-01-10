<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkillController extends AbstractController
{
    #[Route('/admin/skills', name: 'admin_skills')]
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('admin/admin_skill/index.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }
}
