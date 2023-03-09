<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use App\Form\ProfilEditType;
use App\Repository\ProfilRepository;
use App\Repository\SetupRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'profile')]
class ProfileController extends AbstractController
{
    private ProfilRepository $profilRepository;
    private ManagerRegistry $managerRegistry;
    private SetupRepository $setupRepository;
    public function __construct(
        ProfilRepository $profilRepository,
        ManagerRegistry $managerRegistry,
        SetupRepository $setupRepository,
    ) {
        $this->profilRepository = $profilRepository;
        $this->managerRegistry = $managerRegistry;
        $this->setupRepository = $setupRepository;
    }
    
    #[Route('', name: '')]
    public function index(): Response
    {
        return $this->render('profile/indexAdmin.html.twig', [
            'profile' => $this->profilRepository->find(['id' => $this->setupRepository->findOneBy(['name'=>'showProfile'])->getValue()]),
        ]);
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(): Response
    {
        return $this->render('profile/indexAdmin.html.twig', [
            'profiles' => $this->profilRepository->findAll(),
        ]);
    }

    #[Route('-admin/create', name: '-admin-create')]
    public function create(Request $request): Response
    {
        $profile = new Profil();
        $form = $this->createForm(ProfilType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form['image']->getData();

            if ($img) {
            }

            $manager = $this->managerRegistry->getManager();
            $manager->persist($profile);
            $manager->flush();

            $this->addFlash('sucess', 'Profil créé');
            return $this->redirectToRoute('profile-admin');
        }
        return $this->render('profile/formCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/update/{id}', name: '-admin-update')]
    public function update(Request $request, Profil $profile): Response
    {
        $form = $this->createForm(ProfilEditType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form['image']->getData();

            if ($img) {
            }

            $manager = $this->managerRegistry->getManager();
            $manager->persist($profile);
            $manager->flush();

            $this->addFlash('sucess', 'Profil créé');
            return $this->redirectToRoute('profile-admin');
        }

        return $this->render('profile/formUpdate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('-admin/delete/{id}', name: '-admin-delete')]
    public function delete(Profil $profile): Response
    {
        if (count($this->profilRepository->findAll()) > 1) {
            $manager = $this->managerRegistry->getManager();
            $manager->remove($profile);
            $manager->flush();
        }

        return $this->redirectToRoute('profile-admin');
    }
}
