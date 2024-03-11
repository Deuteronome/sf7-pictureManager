<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\RegistrationCodesRepository;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Constraint\IsEmpty;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

use function PHPUnit\Framework\isEmpty;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager, RegistrationCodesRepository $RCRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_gallery');
        }
        
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $verifyCode = $RCRepository->findOneByCode($form->get('code')->getData());
           
            if($verifyCode === null) {
                $this->addFlash('danger', 'Code invalide');

                return $this->redirectToRoute('app_register');
            }

            

            if(!$verifyCode->isIsAvailable()) {
                $this->addFlash('danger', 'Code déjà utilisé');

                return $this->redirectToRoute('app_register');
            }

            $verifyCode->setIsAvailable(false);
            $verifyCode->setUsedBy($user);
            $entityManager-> persist($verifyCode);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
