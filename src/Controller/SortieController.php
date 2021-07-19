<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use App\Entity\Campus;
use App\Entity\Participant;

class SortieController extends AbstractController
{

    /**
     * @Route("/creersortie", name="sortie_creation")
     */
    public function creationSortie(Request $request): Response
    {
        dd($request);
        return $this->render('sortie/creation.html.twig', [
        ]);
    }

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

    /**
     * @Route("/sortie/detail/{id}", name="detailsortie")
     */
    public function detailSortie($id): Response
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findById($id);
        $participants = $sortie[0]->getParticipants();


        return $this->render('sortie/detail.html.twig', [
            'controller_name' => 'EnregistrementController',
            'sortie'=>$sortie,
            'participants'=>$participants,
        ]);
    }
}
