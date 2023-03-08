<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/skill', name: 'skill')]
class SkillController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('Skill/skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(SkillRepository $skillRepository): Response
    {
        return $this->render('Skill/skill/indexAdmin.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }
}
