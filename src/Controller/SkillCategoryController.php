<?php

namespace App\Controller;

use App\Entity\SkillCategory;
use App\Form\SkillCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SkillCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/skill-category', name: 'skill-category')]
class SkillCategoryController extends AbstractController
{
    private SkillCategoryRepository $skillCategoryRepository;
    private ManagerRegistry $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(
        ManagerRegistry $managerRegistry,
        SluggerInterface $slugger,
        SkillCategoryRepository $skillCategoryRepository,
    ) {
        $this->skillCategoryRepository = $skillCategoryRepository;
        $this->managerRegistry = $managerRegistry;
        $this->slugger = $slugger;
    }

    #[Route('-admin', name: '-admin')]
    public function index(Request $request): Response
    {
        $skillCategory = new SkillCategory();
        $form = $this->createForm(SkillCategoryType::class, $skillCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->managerRegistry->getManager();
            $manager->persist($skillCategory);
            $manager->flush();

            return $this->redirectToRoute('skill-category-admin');
        }

        return $this->render('Skill/skill-category/indexAdmin.html.twig', [
            'skillCats' => $this->skillCategoryRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/skill-category-update/{id}', name: '-admin/update')]
    public function update(Request $request, SkillCategory $skillCategory): Response
    {
        $form = $this->createForm(SkillCategoryType::class, $skillCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->managerRegistry->getManager();
            $manager->persist($skillCategory);
            $manager->flush();

            return $this->redirectToRoute('skill_categories');
        }

        return $this->render('admin/admin_skill_category/formEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/skill-category-delete/{id}', name: '-admin/delete')]
    public function delete(): Response
    {
        return $this->redirectToRoute('skill-category-admin');
    }
}
