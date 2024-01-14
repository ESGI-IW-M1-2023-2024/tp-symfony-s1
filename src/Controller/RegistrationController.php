<?php

namespace App\Controller;

use App\Entity\Lyceen;
use App\Entity\User;
use App\Form\LyceenType;
use App\Form\RegistrationChooseEntityFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $type = $form->get('type')->getData();
            switch ($type) {
                case 'admin':
                    $user->setRoles(['ROLE_ADMIN']);
                    break;
                case 'App\Entity\Lyceen':
                    $user->setRoles(['ROLE_LYCEEN']);
                    $user->setEntity($type);
                    break;
                case 'App\Entity\Lycee':
                    $user->setRoles(['ROLE_LYCEE']);
                    $user->setEntity($type);
                    break;
                default:
                    break;
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->security->login($user);

            return $this->redirectToRoute('app_register_link_entity');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register-link-entity', name: 'app_register_link_entity')]
    // #[IsGranted('IS_AUTHENTICATED')]
    public function chooseWhichEntity(Request $request)
    {
        $user = $this->getUser();

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->security->isGranted('ROLE_LYCEEN')) {
            $lyceen = new Lyceen();
            $form = $this->createForm(LyceenType::class, $lyceen, [
                'user' => $user,
            ]);
        } else {
            $form = $this->createForm(RegistrationChooseEntityFormType::class, $user, [
                'entity_related' => $user->getEntity(),
            ]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->security->isGranted('ROLE_LYCEEN')) {
                $lyceen->setDateInscription(new \DateTime());
                $this->entityManager->persist($lyceen);
                $user->setRelatedEntityId($lyceen->getId());
            } else {
                $user->setRelatedEntityId($form->get('relatedEntityId')->getData()->getId());
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register_choose_entity.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/delete', name: 'app_user_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($user as $user) {
            $entityManager->remove($user);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_register', [], Response::HTTP_SEE_OTHER);
    }
}
