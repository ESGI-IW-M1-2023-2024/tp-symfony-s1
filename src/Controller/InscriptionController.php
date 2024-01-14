<?php

namespace App\Controller;

use App\Repository\LyceenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inscription', name: 'app_inscription')]
class InscriptionController extends AbstractController
{
    #[Route('/byLycee/{idLycee}', name: 'app_inscription_par_lycee')]
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

    #[Route('/resume', name: 'app_inscription_resume', methods: ['GET','POST'])]
    public function resume(Request $request, LyceenRepository $lyceenRepository): Response
    {
        $id = $request->query->get('id');
        $lyceen = $lyceenRepository->findOneBy(['id' => $id]);
        return $this->render('inscription/resume.html.twig', [
            'lyceen' => $lyceen,
        ]);
    }
}
