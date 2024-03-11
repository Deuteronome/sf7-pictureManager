<?php

namespace App\Controller;

use App\Entity\RegistrationCodes;
use App\Repository\RegistrationCodesRepository;
use App\Service\RegistrationCodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CodeGeneratorController extends AbstractController
{
    #[Route('/code-inscription', name: 'app_generator')]
    public function index(Request $request, RegistrationCodeService $registrationCodeService, RegistrationCodesRepository $registrationCodesRepository, EntityManagerInterface $em): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $codeList = $this->getUser()->getRegistrationCodes();

        $code = $registrationCodeService->generateCode();
        while (!is_null($registrationCodesRepository->findOneByCode($code))) {
            $code = $registrationCodeService->generateCode();
        }

        $form = $this-> createFormBuilder()->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $registrationCode = new RegistrationCodes();
            $registrationCode -> setCode($code);
            $registrationCode -> setCreatedBy($this->getUser());

            $em->persist($registrationCode);
            $em->flush();

            return $this->redirectToRoute('app_generator');
        }

        return $this->render('code_generator/index.html.twig', [
            'codeList' => $codeList,
            'code' => $code,
            'form' => $form
        ]);
    }
}
