<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\AnsweringQuestionnaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/questionnaire/{id}', name: 'app_questionnaire')]
    public function index($id, Request $request): Response
    {

        $questionnaire = $this->entityManager->getRepository(Questionnaire::class)->find($id);


        $form = $this->createForm(AnsweringQuestionnaireType::class, $questionnaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $this->entityManager->persist($questionnaire);
            // $this->entityManager->flush();

            return $this->redirectToRoute('app_questionnaire', ['id' => $id]);
        }



        return $this->render('questionnaire/index.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'form' => $form->createView(),
        ]);
    }
}
