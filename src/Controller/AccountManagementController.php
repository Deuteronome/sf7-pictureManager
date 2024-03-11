<?php

namespace App\Controller;

use App\Form\ForgottenPasswordType;
use App\Form\PasswordRenewalType;
use App\Repository\UsersRepository;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\UsersAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class AccountManagementController extends AbstractController
{
    

    #[Route('/resetmdp', name: 'app_pwreset')]
    public function resetPassword(Request $request,
        UsersRepository $usersRepository,
        JWTService $jwt,
        SendMailService $mailer
        ): Response
    {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $usersRepository->findOneByEmail($form->get('email')->getData());
            if(!isset($user)){
                $this->addFlash('danger', 'Adresse mail inconnue');

                return $this->redirectToRoute('app_login');
            }

            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            $payload = [
                'user_id' => $user->getId()
            ];

            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtreset'));
            

            // do anything else you need here, like send an email

            $mailer->send(
                'admin@piclib.misterbear.fr',
                $user->getEmail(),
                'Demande de changement de mot de passe',
                'pw_renewal',
                [
                    'user'=>$user,
                    'token' => $token
                ]
            );
            
            $this->addFlash('success', 'Un message de renouvellement de mot de passe vous a été envoyé, vérifiez votre boite mail.');

            return $this->redirectToRoute('app_login');
            
        }

        

        return $this->render('account_management/pwRequest.html.twig', [
            'renewalRequestForm' => $form->createView()
        ]);
    }

    #[Route('//resetmdp/{token}', name: 'app_renewal')]
    public function passwordRenewal(
        $token,
        Request $request,
        JWTService $jwt,
        UsersRepository $usersRepository,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UsersAuthenticator $authenticator
        ): Response
    {
        //token verification

        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->signatureCheck($token, $this->getParameter('app.jwtreset'))) {

            $payload = $jwt->getPayload($token);
            $user = $usersRepository->find($payload['user_id']);
            
            
        } else {
            $this->addFlash('danger', 'Lien invalide');   
            return $this->redirectToRoute('app_main');
        }

        $form = $this->createForm(PasswordRenewalType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($form->get('plainPassword')->getData() != $form->get('confirmPassword')->getData()) {
                $this->addFlash('danger', 'les deux mots de passes doivent être identiques');

                return $this->redirectToRoute('app_renewal', ['token'=>$token]);
            }

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Mot de passe modifié');

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

        }

        $pageInfo = [
            'title' => 'Changement de mot de passe',
            'tabTitle' => 'nouveau mdp'
        ];

        return $this->render('account_management/renewal.html.twig', [
            'renewalForm' => $form->createView(),
            'pageInfo' => $pageInfo
        ]);

    }
}
