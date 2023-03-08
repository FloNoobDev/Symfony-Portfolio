<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProjectCategoryRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/project', name: 'project')]
class ProjectController extends AbstractController
{
    private ProjectCategoryRepository $projectCategoryRepository;
    private ProjectRepository $projectRepository;
    private ManagerRegistry $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(
        ProjectCategoryRepository $projectCategoryRepository,
        ProjectRepository $projectRepository,
        ManagerRegistry $managerRegistry,
        SluggerInterface $slugger,
    ) {
        $this->projectCategoryRepository = $projectCategoryRepository;
        $this->projectRepository = $projectRepository;
        $this->managerRegistry = $managerRegistry;
        $this->slugger = $slugger;
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($project->getCategory()->getName() . '-' . $project->getName()));

            if ($this->projectRepository->findOneBy(['slug' => $slug]) == null) {
                $project->setCreatedAt(new \DateTimeImmutable);
                $date = $form['started_at']->getData();
                $project->setStartedAt(DateTimeImmutable::createFromMutable($date) );
                $project->setSlug($slug);

                $this->addFlash('success', 'Projet ajouté');
                $manager = $this->managerRegistry->getManager();
                $manager->persist($project);
                $manager->flush();
            } else {
                $this->addFlash('warning', 'Projet déjà présent');
            }
        }

        return $this->render('Project/project/indexAdmin.html.twig', [
            'projects' => $this->projectRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/update/{id}', name: '-admin-update')]
    public function update(Request $request, Project $project): Response
    {
        $projetOld = clone $project;

        $form = $this->createForm(ProjectType::class, $project);        
        $form['started_at']->setData(DateTime::createFromImmutable($project->getStartedAt()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($project->getCategory()->getName() . '-' . $project->getName()));

            if ($projetOld->getSlug() == $slug) {
                $this->addFlash('success', 'Projet modifié');
                $manager = $this->managerRegistry->getManager();
                $manager->persist($project);
                $manager->flush();

                return $this->redirectToRoute('project-admin');

            } else {
                if ($this->projectRepository->findOneBy(['slug' => $slug]) == null) {
                    $project->setSlug($slug);
    
                    $this->addFlash('success', 'Projet modifié');
                    $manager = $this->managerRegistry->getManager();
                    $manager->persist($project);
                    $manager->flush();

                    return $this->redirectToRoute('project-admin');
                } else {
                    $this->addFlash('warning', 'Projet déjà présent');
                }
            }            
        }

        return $this->render('Project/project/formEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('-admin/delete/{id}', name: '-admin-delete')]
    public function delete(Project $project): Response
    {

        $this->addFlash('success', 'Projet retiré');
        $manager = $this->managerRegistry->getManager();
        $manager->remove($project);
        $manager->flush();

        return $this->redirectToRoute('project-admin');
    }
}
