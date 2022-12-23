<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/', name: 'app_annonce')]
    public function index(EntityManagerInterface $em): Response
    {
        $listAnnonces = $em->getRepository(Annonce::class)->findAll();
        // dd($listAnnonces[0]->getCategorie()->getTitle());
        return $this->render('annonce/index.html.twig', [
            'listAnnonces' => $listAnnonces
        ]);
    }

    /**
     * Annonce by Id
     * 
     * @Route("/annonce/{id}", name="view_annonce")
     * @param integer $id
     * @param EntityManagerInterface $em
     * @return Annonce
     */
    public function viewAnnonce(int $id, EntityManagerInterface $em){
        $annonce = $em->getRepository(Annonce::class)->find($id);
        // dd($annonce);
        return $this->render('annonce/view_annonce.html.twig', [
            'title' => $annonce->getTitle(),
            'description' => $annonce->getDescription()
        ]);
    }

    /**
     * Crate new annonce
     *
     * @Route()
     * @param Request $request
     * @param EntityManagerInterface $em
     * 
     */
    public function newAnnonce(Request $request, EntityManagerInterface $em){

        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $em->persist($data);
            $em->flush();
            // dd($data);
            return $this->redirectToRoute('app_annonce');
        }

        return $this->renderForm('annonce/form_annonce.html.twig', [
            'form' => $form
        ]);
    }
}