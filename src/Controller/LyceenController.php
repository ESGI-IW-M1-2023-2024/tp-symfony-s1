<?php

namespace App\Controller;

use App\Entity\Lyceen;
use App\Form\LyceenType;
use App\Repository\LyceenRepository;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lyceen')]
class LyceenController extends AbstractController
{
    #[Route('/', name: 'app_lyceen_index', methods: ['GET'])]
    public function index(LyceenRepository $lyceenRepository): Response
    {
        return $this->render('lyceen/index.html.twig', [
            'lyceens' => $lyceenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lyceen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lyceen = new Lyceen();
        $form = $this->createForm(LyceenType::class, $lyceen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lyceen->setDateInscription(new \DateTime());
            $entityManager->persist($lyceen);
            $entityManager->flush();

            return $this->redirectToRoute('app_lyceen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lyceen/new.html.twig', [
            'lyceen' => $lyceen,
            'form' => $form,
        ]);
    }

    #[Route('/inscription', name: 'app_lyceen_inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $lyceen = new Lyceen();
        $form = $this->createForm(LyceenType::class, $lyceen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $request->getSession()->getFlashBag()->set('error', '');
            $lyceen->setDateInscription(new \DateTime());

            $formAteliers = array($form->get('atelier_1')->getData(), $form->get('atelier_2')->getData(), $form->get('atelier_3')->getData());
            $has_duplicates = count($formAteliers) !== count(array_unique($formAteliers)) && !in_array(null, $formAteliers);
            if ($has_duplicates) {
                $this->addFlash('error', 'Vous ne pouvez pas vous inscrire à plusieurs ateliers identiques.');
                return $this->redirectToRoute('app_lyceen_inscription');
            }

            $entityManager->persist($lyceen);
            $entityManager->flush();

            $mailSender = new Mail($mailer, $_ENV['MAILER_FROM']);
            $mailSender->sendMailAfterRegistration($lyceen->getEmail(), [
                'lyceen' => $lyceen,
            ]);

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lyceen/inscription.html.twig', [
            'lyceen' => $lyceen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lyceen_show', methods: ['GET'])]
    public function show(Lyceen $lyceen): Response
    {
        return $this->render('lyceen/show.html.twig', [
            'lyceen' => $lyceen,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lyceen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lyceen $lyceen, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LyceenType::class, $lyceen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lyceen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lyceen/edit.html.twig', [
            'lyceen' => $lyceen,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_lyceen_delete', methods: ['POST'])]
    public function delete(Request $request, Lyceen $lyceen, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lyceen->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lyceen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lyceen_index', [], Response::HTTP_SEE_OTHER);
    }

}
