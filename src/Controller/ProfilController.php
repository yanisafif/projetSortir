<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{

    /**
     * @Route("/editer", name="editer")
     */
    public function editer(): Response
    {
        return $this->render('profil/editer.html.twig');
    }



    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(): Response
    {
        return $this->render('profil/details.html.twig', [
            'controller_name' => 'EnregistrementController',
        ]);
    }







}
