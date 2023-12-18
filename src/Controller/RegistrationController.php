<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationChooseEntityFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
            if ('admin' == $type) {
                $user->addRoles(['ROLE_ADMIN']);
            } else {
                $user->setEntity($type);
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

        $form = $this->createForm(RegistrationChooseEntityFormType::class, $user, [
            'entity_related' => $user->getEntity(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRelatedEntityId($form->get('relatedEntityId')->getData()->getId());
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
