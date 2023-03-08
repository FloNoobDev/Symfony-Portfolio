<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile')]
class ProfileController extends AbstractController
{
    private ProfilRepository $profilRepository;

    public function __construct(
        ProfilRepository $profilRepository,
    ) {
        $this->profilRepository = $profilRepository;
    }

    #[Route('-admin', name: '-admin')]
    public function index(): Response
    {
        return $this->render('profile/indexAdmin.html.twig', [
            'profiles' => $this->profilRepository->findAll(),
        ]);
    }

    #[Route('-admin/create', name: '-admin-create')]
    public function create(): Response
    {
        return $this->render('admin/_profile/createProfile.html.twig', [
            'controller_name' => 'AdminProfileController',
        ]);
    }
    #[Route('-admin/update/{id}', name: '-admin-update')]
    public function update(): Response
    {
        return $this->render('admin/_profile/updateProfile.html.twig', [
            'controller_name' => 'AdminProfileController',
        ]);
    }
}
