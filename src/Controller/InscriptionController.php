<?php

namespace App\Controller;

use App\Repository\AtelierRepository;
use App\Repository\LyceenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inscription')]
class InscriptionController extends AbstractController
{
    #[Route('/', name: 'app_inscription_index')]
    public function index(Request $request, AtelierRepository $atelierRepository)
    {
        $idAtelier = $request->query->get('id');
        $creneau = $request->query->get('creneau');

        if ($idAtelier) {
            if ($creneau) {
                $ateliers = $atelierRepository->findOneBy(['id' => $idAtelier, 'heure' => $creneau]);
            } else {
                $ateliers = $atelierRepository->findOneBy(['id' => $idAtelier]);
            }
        } else if($creneau) {
            $ateliers = $atelierRepository->findOneBy(['heure' => $creneau]);
        } else {
            $ateliers = $atelierRepository->findAll();
        }


        $response = [];

        foreach ($ateliers as $atelier) {
            $response[] = [
                'id' => $atelier->getId(),
                'nom' => $atelier->getNom(),
                'heure' => $atelier->getHeure(),
                'secteur' => $atelier->getSecteur()->getNom(),
                'salle' => $atelier->getSalle()->getNom(),
                'metiers' => $atelier->getMetiers(),
                'ressources' => $atelier->getRessources(),
                'nbIntervenants' => sizeof($atelier->getIntervenants()),
                'nbLyceens' => sizeof($atelier->getLyceens()),
            ];
        }
        return $this->json($response);
    }

    #[Route('/byLycee/{idLycee}', name: 'app_inscription_par_lycee')]
    public function byLycee($idLycee, LyceenRepository $lyceenRepository): Response
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

    #[Route('/resume', name: 'app_inscription_resume')]
    public function resume(Request $request, LyceenRepository $lyceenRepository): Response
    {
        $id = $request->query->get('id');
        $lyceen = $lyceenRepository->findOneBy(['id' => $id]);
        return $this->render('inscription/resume.html.twig', [
            'lyceen' => $lyceen,
        ]);
    }
}
