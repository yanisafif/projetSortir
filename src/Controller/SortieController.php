<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use App\Entity\Campus;
use App\Entity\Participant;
Use App\Entity\Etat;

class SortieController extends AbstractController
{

    /**
     * @Route("/creersortie", name="sortie_creation")
     */
    public function creationSortie(Request $request): Response
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        //todo traiter le formulaire

        return $this->render('sortie/creation.html.twig', [
            'controller_name' => 'EnregistrementController',
            'sortieForm' => $sortieForm->createView()
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
            'campus' => $campus,
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
            'sortie' => $sortie,
            'participants' => $participants,
        ]);
    }

    /**
     * @Route("/sortie/annuler/{id}", name="annulersortie")
     */
    public function annulerSortie($id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $sortie = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findById($id);

        $etatAnnule = $this->getDoctrine()
            ->getRepository(Etat::class)
            ->findOneBy(array('libelle' => 'Annulée'));
//        $sortie->($etatAnnule);
        $etatAnnule->addSorty($sortie[0]);
        $em->persist($etatAnnule);
        $em->flush();
         return $this->redirectToRoute('sortie');
    }

    /**
     * @Route("/sortie/formannuler/{id}", name="formannuler")
     */
    public function formAnnuler($id): Response
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findById($id);
        $participants = $sortie[0]->getParticipants();


        return $this->render('sortie/formannuler.html.twig', [
            'controller_name' => 'EnregistrementController',
            'sortie' => $sortie,
            'participants' => $participants,
        ]);
    }

    /**
     * @Route("/sortie/desiste/{id}", name="desiste")
     */
    public function desiste($id): Response
    {
        $sortie = $this->getDoctrine()
            ->getRepository(Sortie::class)
            ->findById($id);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $participant = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->findOneBy(array('pseudo' => $user));

//        $sortie->removeParticipant($participant[0]);


//        return $this->redirectToRoute('sortie');
    }
//    Request $request)
}
