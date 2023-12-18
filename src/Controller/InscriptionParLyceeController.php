<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionParLyceeController extends AbstractController
{
    #[Route('/inscription/par/lycee', name: 'app_inscription_par_lycee')]
    public function index(): Response
    {
        return $this->render('inscription_par_lycee/index.html.twig', [
            'inscriptions' => $lyceeRepository->findAll(),
        ]);
    }
}
