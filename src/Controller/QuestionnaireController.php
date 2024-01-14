<?php

namespace App\Controller;

use App\Entity\Lyceen;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Form\AnsweringQuestionnaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class QuestionnaireController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/questionnaire/{id}', name: 'app_questionnaire')]
    #[IsGranted('ROLE_LYCEEN')]
    public function index($id, Request $request): Response
    {

        $lyceen = $this->entityManager->getRepository(Lyceen::class)->find($this->getUser()->getRelatedEntityId());

        if (!$lyceen) {
            return $this->redirectToRoute('app_home');
        }
        
        $questionnaire = $this->entityManager->getRepository(Questionnaire::class)->find($id);

        $questions = $questionnaire->getQuestions();

        $form = $this->createForm(AnsweringQuestionnaireType::class, null, [
            'questions' => $questions
        ]);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $questionArray = [];
            foreach ($questions as $question) {
                $questionArray[$question->getId()] = $question;
            }

            $data = $form->getData();

            foreach ($data as $key => $value) {
                if ($key !== 'submit') {
                    $reponse = new Reponse();
                    $reponse->setContenu($value);
                    $reponse->setQuestion($questionArray[$key]);
                    $reponse->setLyceen($lyceen);
                    $this->entityManager->persist($reponse);
                }
            }

            $this->entityManager->flush();

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
