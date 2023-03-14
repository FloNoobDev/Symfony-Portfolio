<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\SetupRepository;
use App\Repository\SkillRepository;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Mime\Address;
use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillCategoryRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\ProjectCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/', name: 'index')]
class IndexController extends AbstractController
{
    private SkillCategoryRepository $skillCatRepo;
    private SkillRepository $skillRepo;
    private ProjectCategoryRepository $projectCatRepo;
    private ProjectRepository $projectRepo;
    private ProfilRepository $profilRepository;
    private SetupRepository $setupRepository;


    public function __construct(
        SkillCategoryRepository $skillCatRepo,
        SkillRepository $skillRepo,
        ProjectCategoryRepository $projectCatRepo,
        ProjectRepository $projectRepo,
        ProfilRepository $profilRepository,
        SetupRepository $setupRepository,
    ) {
        $this->skillCatRepo = $skillCatRepo;
        $this->skillRepo = $skillRepo;
        $this->projectCatRepo = $projectCatRepo;
        $this->projectRepo = $projectRepo;
        $this->profilRepository = $profilRepository;
        $this->setupRepository = $setupRepository;
    }

    #[Route('/', name: '')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $formContact = $this->createForm(ContactType::class);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            if (empty($formContact['honeypot']->getData())) {
                $contact = $formContact->getData();

                $email = (new TemplatedEmail())
                    ->from(new Address($this->getParameter('dev_contact_mail'), 'Website'))
                    ->to(new Address($this->getParameter('dev_contact_mail'), 'Portefolio'))
                    ->addCc(new Address($contact['email'], $contact['firstName'] . ' ' . $contact['lastName']))
                    ->replyTo(new Address($contact['email'], $contact['firstName'] . ' ' . $contact['lastName']))
                    ->subject('HEINE Florian - ' . $contact['subject'])
                    ->htmlTemplate('email/contact.html.twig')
                    ->context([
                        'firstName' => $contact['firstName'],
                        'lastName' => $contact['lastName'],
                        'emailAddress' => $contact['email'],
                        'subject' => $contact['subject'],
                        'message' => $contact['message']
                    ]);

                $mailer->send($email);
                $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
                return $this->redirectToRoute('index');
            } else {
                $this->addFlash('danger', 'Are you for real ?');
                return $this->redirectToRoute('index');
            }
        }

        return $this->render('home/index.html.twig', [
            'profile' => $this->profilRepository->find(['id' => $this->setupRepository->findOneBy(['name' => 'showProfile'])->getValue()]),
            'projectsCats' => $this->projectCatRepo->findAll(),
            'skillsCategories' => $this->skillCatRepo->findAll(),
            'formContact' => $formContact->createView(),
        ]);
    }

    #[Route('/admin', name: '-admin')]
    public function indexAdmin(): Response
    {
        return $this->render('home/indexAdmin.html.twig', [
            'projectCatCount' => count($this->projectCatRepo->findAll()),
            'projectCount' => count($this->projectRepo->findAll()),
            'skillCatCount' => count($this->skillCatRepo->findAll()),
            'skillCount' => count($this->skillRepo->findAll()),
        ]);
    }
}
