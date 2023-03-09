<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile')]
class ProfileController extends AbstractController
{
    private ProfilRepository $profilRepository;
    private ManagerRegistry $managerRegistry;
    public function __construct(
        ProfilRepository $profilRepository,
        ManagerRegistry $managerRegistry,
    ) {
        $this->profilRepository = $profilRepository;
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('', name: '')]
    public function index(): Response
    {
        return $this->render('profile/indexAdmin.html.twig', [
            'profile' => $this->profilRepository->findOneBy(['name' => 'heine']),
        ]);
    }

    #[Route('-admin', name: '-admin')]
    public function indexAdmin(): Response
    {
        dd($this->profilRepository->findAll());
        return $this->render('profile/indexAdmin.html.twig', [
            'profiles' => $this->profilRepository->findAll(),
        ]);
    }

    #[Route('-admin/create', name: '-admin-creae')]
    public function create(Request $request): Response
    {
        $profile = new Profil();
        $form = $this->createForm(ProfileType::class, $profile);
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
        $form = $this->createForm(ProfileType::class, $profile);
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
