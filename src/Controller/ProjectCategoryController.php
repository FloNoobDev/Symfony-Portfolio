<?php

namespace App\Controller;

use App\Entity\ProjectCategory;
use App\Form\ProjectCategoryType;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/project-category', name: 'project-category')]
class ProjectCategoryController extends AbstractController
{
    private ProjectCategoryRepository $projectCategoryRepository;
    private ManagerRegistry $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(
        ProjectCategoryRepository $projectCategoryRepository,
        ManagerRegistry $managerRegistry,
        SluggerInterface $slugger,
    ) {
        $this->projectCategoryRepository = $projectCategoryRepository;
        $this->managerRegistry = $managerRegistry;
        $this->slugger = $slugger;
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(Request $request): Response
    {
        $projectCategory = new ProjectCategory();
        $form = $this->createForm(ProjectCategoryType::class, $projectCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($projectCategory->getName()));
            if (count($this->projectCategoryRepository->findBy(['slug' => $slug])) > 0) {
            } else {

                $projectCategory->setSlug($slug);


                $projectCategory->setCreateAt(new \DateTimeImmutable);

                $manager = $this->managerRegistry->getManager();
                $manager->persist($projectCategory);
                $manager->flush();
                return $this->redirectToRoute('project-category-admin');
            }
        }

        return $this->render('Project/project-category/indexAdmin.html.twig', [
            'projectCats' => $this->projectCategoryRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/update/{id}', name: '-admin-update')]
    public function updateProjCat(ProjectCategory $projectCategory, Request $request): Response
    {
        $slugOld = $projectCategory->getSlug();

        $form = $this->createForm(ProjectCategoryType::class, $projectCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($projectCategory->getName()));
            if (count($this->projectCategoryRepository->findBy(['slug' => $slug])) > 0) {
            } else {
                $projectCategory->setSlug($slug);

                $manager = $this->managerRegistry->getManager();
                $manager->persist($projectCategory);
                $manager->flush();
                return $this->redirectToRoute('project-category-admin');
            }
        }

        return $this->render('Project/project-category/formEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/delete/{id}', name: '-admin-delete')]
    public function deleteProjCat(ProjectCategory $projectCategory): Response
    {
        if (count($projectCategory->getProjects()) == 0) {
            $manager = $this->managerRegistry->getManager();
            $manager->remove($projectCategory);
            $manager->flush();
        }

        return $this->redirectToRoute('project-category-admin');
    }
}
