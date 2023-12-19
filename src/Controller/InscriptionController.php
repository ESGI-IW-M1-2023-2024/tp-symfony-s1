<?php

namespace App\Controller;

use App\Repository\AtelierRepository;
use App\Repository\LyceenRepository;
use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inscription')]
class InscriptionController extends AbstractController
{
    #[Route('/byLycee/{idLycee}', name: 'app_inscription_par_lycee')]
    public function index($idLycee, LyceenRepository $lyceenRepository, InscriptionRepository $inscriptionRepository): Response
    {
        // Récupérez le lycée en fonction de l'idLycee
        $lycee = $lyceenRepository->find($idLycee);

        if (!$lycee) {
            throw $this->createNotFoundException('Lycée non trouvé');
        }

        // Récupérez les inscriptions spécifiques à ce lycée
        $inscriptions = $inscriptionRepository->findBy(['lycee' => $lycee]);

        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }
    #[Route('/byAtelier/{idAtelier}', name: 'app_inscription_par_atelier')]
    public function indexAtelier($idAtelier, LyceenRepository $lyceenRepository, InscriptionRepository $inscriptionRepository): Response
    {
        // Récupérez l'atelier en fonction de l'idAtelier
        $atelier = $lyceenRepository->find($idAtelier);

         if (!$atelier) {
             throw $this->createNotFoundException('Atelier non trouvé');
         }

        // Récupérez les inscriptions spécifiques à cet atelier
        $inscriptions = $inscriptionRepository->findBy(['atelier' => $atelier]);

        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }
    #[Route('/byAtelier', name: 'app_inscription_atelier')]
    public function AllAtelier(AtelierRepository $atelierRepository): Response
    {
        $ateliers = $atelierRepository->findAll();

        return $this->render('inscription/monitoring.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }   
}
