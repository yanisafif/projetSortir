<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
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
     * @Route("/{id}", name="detail")
     */
        public function detail(int $id, ParticipantRepository $participantRepository): Response
    {
        $participant = $participantRepository->find($id);
        if (!$participant) {
            $this->addFlash("warning", "Participant non trouvé");
            return $this->redirectToRoute('sortir');
        }
        return $this->render('profil/detail.html.twig', [
            "participant" => $participant
        ]);
    }








}
