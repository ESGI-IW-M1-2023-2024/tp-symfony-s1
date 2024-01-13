<?php

namespace App\Controller;

use App\Entity\Lyceen;
use App\Form\LyceenType;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionAtelierController extends AbstractController
{
    #[Route('/inscriptions', name: 'app_lyceen_inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $lyceen = new Lyceen();
        $form = $this->createForm(LyceenType::class, $lyceen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$request->getSession()->getFlashBag()->set('error', '');
            $lyceen->setDateInscription(new \DateTime());

            $formAteliers = array($form->get('atelier_1')->getData(), $form->get('atelier_2')->getData(), $form->get('atelier_3')->getData());
            $has_duplicates = count($formAteliers) !== count(array_unique($formAteliers)) && !in_array(null, $formAteliers);
            if ($has_duplicates) {
                $this->addFlash('error', 'Vous ne pouvez pas vous inscrire à plusieurs ateliers identiques.');
                return $this->redirectToRoute('app_lyceen_inscription');
            }

            foreach ($formAteliers as $atelier) {
                if ($atelier) {
                    $lyceen->addAtelier($atelier);
                }
            }

            $entityManager->persist($lyceen);
            $entityManager->flush();

            $mailSender = new Mail($mailer, $_ENV['MAILER_FROM']);
            $mailSender->sendMailAfterRegistration($lyceen->getEmail(), [
                'lyceen' => $lyceen,
            ]);

            return $this->redirectToRoute('app_inscription_resume', [
                'id' => $lyceen->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('inscription_atelier/index.html.twig', [
            'lyceen' => $lyceen,
            'form' => $form,
        ]);
    }
}
