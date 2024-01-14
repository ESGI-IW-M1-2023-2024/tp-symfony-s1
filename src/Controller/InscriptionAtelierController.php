<?php

namespace App\Controller;

use App\Entity\Lyceen;
use App\Form\LyceenType;
use App\Service\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class InscriptionAtelierController extends AbstractController
{
    #[Route('/inscription', name: 'app_lyceen_inscription', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_LYCEEN')]
    public function inscription(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, Security $security): Response
    {
        $lyceen = $entityManager->getRepository(Lyceen::class)->find($security->getUser()->getRelatedEntityId());
        $form = $this->createForm(LyceenType::class, $lyceen, [
            'inscription' => true,
        ]);
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

    #[Route('/inscription/resume/{id}', name: 'app_inscription_resume', methods: ['GET'])]
    #[IsGranted('ROLE_LYCEEN')]
    public function resume(Lyceen $lyceen): Response
    {
        return $this->render('inscription_atelier/resume.html.twig', [
            'lyceen' => $lyceen,
        ]);
    }
}
