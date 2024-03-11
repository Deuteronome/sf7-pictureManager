<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeletePictureController extends AbstractController
{
    #[Route('/del-picture/{id}', name: 'app_delete')]
    public function index(int $id, EntityManagerInterface $em, ImagesRepository $imagesRepository): Response
    {
        
        
        $image = $imagesRepository->findOneById($id);

        if($image === null){
            $this->addFlash('danger', 'Image inexistante');
        }else if($image->getOwner() === $this->getUser()) {
            $em->remove($image);
            $em->flush();
        } else {
            $this->addFlash('danger', 'Action interdite');
        }
        
        
        return $this->redirectToRoute('app_gallery');
    }
}
