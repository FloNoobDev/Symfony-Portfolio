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
            $slug = strtolower($this->slugger->slug($skillCategory->getName()));

            if ($this->skillCategoryRepository->findOneBy(['slug' => $slug]) == null) {
                $skillCategory->setCreatedAt(new \DateTimeImmutable);
                $skillCategory->setSlug($slug);

                $manager = $this->managerRegistry->getManager();
                $manager->persist($skillCategory);
                $manager->flush();
                $this->addFlash('success', 'Catégorie ajoutée');

                return $this->redirectToRoute('skill-category-admin');
            } else {
                $this->addFlash('warning', 'Catégorie déjà présente');
            }
        }

        return $this->render('Skill/skill-category/indexAdmin.html.twig', [
            'skillCats' => $this->skillCategoryRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }


    #[Route('-admin/update/{id}', name: '-admin-update')]
    public function update(Request $request, SkillCategory $skillCategory): Response
    {
        $skillCategoryOld = clone $skillCategory;

        $form = $this->createForm(SkillCategoryType::class, $skillCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($skillCategory->getName()));
            $manager = $this->managerRegistry->getManager();

            if ($slug == $skillCategoryOld->getSlug()) {
                $manager->persist($skillCategory);
                $manager->flush();
                $this->addFlash('success', 'Catégorie modifiée');

                return $this->redirectToRoute('skill-category-admin');
            } else {
                if ($this->skillCategoryRepository->findOneBy(['slug' => $slug]) == null) {
                    $skillCategory->setSlug($slug);

                    $manager->persist($skillCategory);
                    $manager->flush();
                    $this->addFlash('success', 'Catégorie modifiée');

                    return $this->redirectToRoute('skill-category-admin');
                } else {
                    $this->addFlash('warning', 'Catégorie déjà présente');
                }
            }
        }

        return $this->render('Skill/skill-category/formEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('-admin/delete/{id}', name: '-admin-delete')]
    public function delete(SkillCategory $skillCategory): Response
    {
        if (count($skillCategory->getSkills()) > 0) {
            $this->addFlash('warning', 'Catégorie utilisée');
        } else {
            $manager = $this->managerRegistry->getManager();
            $manager->remove($skillCategory);
            $manager->flush();

            $this->addFlash('warning', 'Catégorie supprimée');
        }
        return $this->redirectToRoute('skill-category-admin');
    }
}
