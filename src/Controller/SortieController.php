<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use App\Entity\Campus;

class SortieController extends AbstractController
{
    /**
     * @Route("/listesorties", name="sortie")
     */
    public function listeSorties()
    {
        $sorties = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findAll();
        $campus = $this->getDoctrine()
            ->getRepository(Campus::class)
            ->findAll();

        return $this->render('sortie/index.html.twig', [
            'sorties' => $sorties,
            'campus'=> $campus,
        ]);
    }
}
