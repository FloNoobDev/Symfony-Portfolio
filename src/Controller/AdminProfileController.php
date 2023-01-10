<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProfileController extends AbstractController
{
    #[Route('/admin/profile', name: 'admin_profiles')]
    public function index(ProfilRepository $profilRepository): Response
    {
        return $this->render('admin/admin_profile/index.html.twig', [
            'profiles'=>$profilRepository->findAll(),
        ]);
    }

    #[Route('/admin/profile/create', name: 'create_profile')]
    public function create(): Response
    {
        return $this->render('admin/_profile/createProfile.html.twig', [
            'controller_name' => 'AdminProfileController',
        ]);
    }
    #[Route('/admin/profile/{id}', name: 'update_profile')]
    public function update(): Response
    {
        return $this->render('admin/_profile/updateProfile.html.twig', [
            'controller_name' => 'AdminProfileController',
        ]);
    }
}