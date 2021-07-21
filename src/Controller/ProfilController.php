<?php

namespace App\Controller;

use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/{id}", name="editer")
     */
    public function editer(int $id,
                           ParticipantRepository $participantRepository,
                           Request $request,
                           EntityManagerInterface $entityManager,
                           SluggerInterface $slugger): Response
    {
        $participant = $participantRepository->find($id);
        $formParticipant = $this->createForm(ParticipantType::class, $participant);
        $formParticipant->handleRequest($request);
        if ($formParticipant->isSubmitted() && $formParticipant->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $formParticipant->get('maPhoto')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();
                try {
                    $photoFile->move(
                        $this->getParameter('dossier_photos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw $e;
                }
                $participant->setPhoto($newFilename);
            }
            $entityManager->persist($participant);
            $entityManager->flush();
            $this->addFlash('success', 'Le participant a été mis à jour');
            return $this->redirectToRoute('profil_detail', ['id' => $participant->getId()]) ;
        }
        return $this->render('profil/editer.html.twig', ['formParticipant' => $formParticipant->createView()]);
    }

    /**
     * @Route("/{id}/detail", name="detail")
     */
    public function detail(int $id, ParticipantRepository $participantRepository): Response
    {
        $participant = $participantRepository->find($id);
        if (!$participant) {
            $this->addFlash("warning", "Participant non trouvé");
            return $this->redirectToRoute('sortie');
        }
        return $this->render('profil/profil.html.twig', [
            "participant" => $participant
        ]);
    }








}
