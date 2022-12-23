<?php

namespace App\Controller;

use DateTime;
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
        // dd($listAnnonces);
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
        // dd($this->getUser());
        return $this->render('annonce/view_annonce.html.twig', [
            'title' => $annonce->getTitle(),
            'description' => $annonce->getDescription(),
            'annonce' => $annonce
        ]);
    }

    /**
     * Create new annonce
     *
     * @Route("/create/annonce", name="create_annonce")
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
            $data = $annonce->setCreatedAt(new DateTime());
            $data = $annonce->setAnnonceByUser($this->getUser());
            // dd($data);
            $em->persist($data);
            $em->flush();
            
            return $this->redirectToRoute('app_annonce');
        }

        return $this->renderForm('annonce/form_annonce.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * Edit Annonce by Id
     * 
     * @Route("/edit/annonce/{id}", name="edit_annonce")
     * @param integer $id
     * @param EntityManagerInterface $em
     * @return Annonce
     */
    public function editAnnonce(int $id, EntityManagerInterface $em)
    {
        return 'TODO';
    }

     /**
     * Remove annonce  by Id
     * 
     * @Route("/remove/annonce/{id}", name="remove_annonce")
     * @param integer $id
     * @param EntityManagerInterface $em
     * @return Annonce
     */
    public function deleteAnnonce(int $id, EntityManagerInterface $em)
    {
        return 'TODO';
    }
}
