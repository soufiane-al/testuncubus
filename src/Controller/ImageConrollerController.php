<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImageConrollerController extends AbstractController
{
    /**
     * @Route("/image/conroller", name="image_conroller")
     */
    public function index()
    {
        return $this->render('image_conroller/index.html.twig', [
            'controller_name' => 'ImageConrollerController',
        ]);
    }

    /**
     * @Route("/image/add", name="add_image")
     * @param Request $request
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        if(Request::METHOD_POST === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isValid())  {
                $entityManager->persist($image);
                $entityManager->flush();
            }
        }
        return $this->render('image/add.html.twig', ['form' => $form->createView()]);
    }
}
