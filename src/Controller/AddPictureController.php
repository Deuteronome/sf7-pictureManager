<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\AddPictureType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddPictureController extends AbstractController
{
    #[Route('/add-picture', name: 'app_picture')]
    public function index(Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $form = $this->createForm(AddPictureType::class);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $image = new Images();
            $image->setName($form->get('name')->getData());
            $image-> setOwner($this->getUser());
            $image->setCreatedAt(new \DateTimeImmutable());

            $fileName = $pictureService->add($form->get('image')->getData(), (string)$this->getUser()->getId());

            
            $image->setFileName($fileName);

            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('app_gallery');
        }
        
        return $this->render('add_picture/index.html.twig', [
            'form' => $form
        ]);
    }
}
