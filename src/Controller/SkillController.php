<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Form\SkillEditType;
use App\Repository\SkillRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/skill', name: 'skill')]
class SkillController extends AbstractController
{
    private SkillRepository $skillRepository;
    private ManagerRegistry $managerRegistry;
    private SluggerInterface $slugger;

    public function __construct(
        SluggerInterface $slugger,
        ManagerRegistry $managerRegistry,
        SkillRepository $skillRepository,
    ) {
        $this->slugger = $slugger;
        $this->managerRegistry = $managerRegistry;
        $this->skillRepository = $skillRepository;
    }

    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('Skill/skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($skill->getCategory()->getName() . '-' . $skill->getName()));

            if ($this->skillRepository->findOneBy(['slug' => $slug]) == null) {
                $manager = $this->managerRegistry->getManager();
                $skill->setCreatedAt(new \DateTimeImmutable);
                $skill->setSlug($slug);

                $img = $form['image']->getData();
                $imgName = time() . '.' . $img->guessExtension();
                $skill->setImage($imgName);
                $img->move($this->getParameter('skill_img_dir'), $imgName);

                $manager->persist($skill);
                $manager->flush();
            } else {
            }
        }

        return $this->render('Skill/skill/indexAdmin.html.twig', [
            'skills' => $this->skillRepository->findBy([], ['category' => 'DESC']),
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/update/{id}', name: '-admin-update')]
    public function update(Request $request, Skill $skill): Response
    {
        $skillOld = clone $skill;
        $form = $this->createForm(SkillEditType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = strtolower($this->slugger->slug($skill->getCategory()->getName() . '-' . $skill->getName()));

            if ($skillOld->getCreatedAt() == null) {
                $skill->setCreatedAt(new \DateTimeImmutable);
            }

            if($skill->getSlug()==null){
                $skill->setSlug($slug);
            }

            if ($slug == $skillOld->getSlug()) {
                $img = $form['image']->getData();
                dd($img);
                if($img){
                    $imgName = time() . '.' . $img->guessExtension();
                    $skill->setImage($imgName);
                    $img->move($this->getParameter('skill_img_dir'), $imgName);

                    if(file_exists($this->getParameter('skill_img_dir').'/'.$skillOld->getImage())){
                        unlink($this->getParameter('skill_img_dir').'/'.$skillOld->getImage());
                    }
                }                    
            }

            $manager = $this->managerRegistry->getManager();



            $manager->persist($skill);
            $manager->flush();
        }

        return $this->render('Skill/skill/formEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/delete/{id}', name: '-admin-delete')]
    public function delete(Skill $skill): Response
    {
        $manager = $this->managerRegistry->getManager();
        $manager->remove($skill);
        $manager->flush();

        return $this->redirectToRoute('skill-admin');
    }
}
