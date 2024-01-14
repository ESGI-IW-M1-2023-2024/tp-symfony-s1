<?php

namespace App\Controller;

use App\Entity\Atelier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AtelierController extends AbstractController
{
    #[Route('/ateliers', name: 'app_atelier_listing')]
    public function index(EntityManagerInterface $em): Response
    {
        $ateliers = $em->getRepository(Atelier::class)->findAll();

        return $this->render('atelier/listing.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }

    #[Route('/atelier/{id}', name: 'app_atelier_public_show')]
    public function showPublic(EntityManagerInterface $em, $id): Response
    {
        $atelier = $em->getRepository(Atelier::class)->find($id);

        return $this->render('atelier/show.html.twig', [
            'atelier' => $atelier,
        ]);
    }
}
