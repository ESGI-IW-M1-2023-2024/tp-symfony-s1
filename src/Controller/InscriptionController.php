<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use App\Repository\LyceenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription/byLycee/{idLycee}', name: 'app_inscription_par_lycee')]
    public function index($idLycee, LyceenRepository $lyceenRepository): Response
    {
        $lyceens = $lyceenRepository->findByLycee($idLycee);
        $ateliers = [];
        foreach ($lyceens as $lyceen) {
            $ateliers[$lyceen->getId()] = $lyceen->getAteliers();
        }

        return $this->render('inscription/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }
}
