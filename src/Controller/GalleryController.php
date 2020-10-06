<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalleryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallery", name="gallery")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        $galleries = $entityManager->getRepository(Galerie::class)->findAll();
        return $this->json([
            'message' => 'Welcome to your new controller!'.count($galleries),
            'path' => 'src/Controller/GelleryController.php',
        ]);
    }

    /**
     * @Route("/gallery/add", name="add_gallery")
     * @param Request $request
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $gallery = new Galerie();
        $form = $this->createForm(GalleryType::class, $gallery);
        if(Request::METHOD_POST === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isValid())  {
                $entityManager->persist($gallery);
                $entityManager->flush();
            }
        }
        return $this->render('gallery/add.html.twig', ['form' => $form->createView()]);
    }
}
