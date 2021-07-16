<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/ville", name="ville")
     */
    public function ville(): Response
    {
        //todo : attendre Entity ville
        return $this->render('admin/ville.html.twig', [
            'controller_name' => 'AdminController',
        ]);


    }

    /**
     * @Route("/campus", name="campus")
     */
    public function campus(
        CampusRepository $campusRepository,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $campus = $campusRepository->findAll();

        $newCampus = new Campus();
        $form = $this->createForm(CampusType::class, $newCampus);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newCampus->setNom(  // on met le nom du campus comme :
                strtoupper( // une chaine en majuscule
                    $form->get('nom') // on prend le champ 'nom' du formulaire
                    ->getData()));

                $entityManager->persist($newCampus);
                $entityManager->flush();
                }



        return $this->render('admin/campus.html.twig', [
            "campus" => $campus,
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/campus/modification/{id}", name="modif")
     */
    public function campusModification(
        Campus $modifyCampusName,
        CampusRepository $campusRepository,
        $id,
        entityManagerInterface $entityManager,
        Request $request): Response
    {
        $campus = $campusRepository->findById($id);
        $form = $this->createForm(CampusType::class, $modifyCampusName);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $modifyCampusName->setNom(strtoupper($form->get('nom')->getData()));
            $entityManager->persist($modifyCampusName);
            $entityManager->flush();
        }

        return $this->render('admin/modificationCampus.html.twig', [
            'controller_name' => 'AdminController',
            "campus" => $campus,
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/campus/supprime/{id}", name="delete")
     */
    public function campusDelete(Campus $campus, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($campus);
        $entityManager->flush();
        return $this->redirectToRoute('admin_campus');
    }
}
