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
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class AnnonceController extends AbstractController
{
    #[Route('/', name: 'app_annonce')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {   
        // $listAnnonces = $em->getRepository(Annonce::class)->getAllAnnoncesByDate();
        // return $this->render('annonce/index.html.twig', [
        //     'listAnnonces' => $listAnnonces
        // ]);
        
        $querybuilder = $em->getRepository(Annonce::class)->createOrderedByDateQueryBuilder();
        $adapter = new QueryAdapter($querybuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            8
        );
        return $this->render('annonce/index.html.twig', [
            'pager' => $pagerfanta
        ]);
    }

    #[Route('/mes-annonces', name: 'view_my_annonce')]
    public function viewMyAnnonces(EntityManagerInterface $em, Request $request): Response
    {   
        // $listAnnonces = $em->getRepository(Annonce::class)->getAllAnnoncesByDate();
        // return $this->render('annonce/index.html.twig', [
        //     'listAnnonces' => $listAnnonces
        // ]);

        $querybuilder = $em->getRepository(Annonce::class)->myAnnoncesOrderedByDateQueryBuilder($this->getUser()->getId());
        $adapter = new QueryAdapter($querybuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            8
        );
        return $this->render('annonce/index.html.twig', [
            'pager' => $pagerfanta
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

        if (!$annonce){
            throw $this->createNotFoundException('No annonce found'); 
        }
        return $this->render('annonce/view_annonce.html.twig', [
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
            $em->persist($data);
            $em->flush();
            
            return $this->redirectToRoute('app_annonce');
        }

        return $this->renderForm('annonce/form_annonce.html.twig', [
            'form' => $form,
            'createdAt' => null
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
    public function editAnnonce(int $id, EntityManagerInterface $em, Request $request)
    {
        $annonce = $em->getRepository(Annonce::class)->find($id);

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $data = $annonce->setUpdatedAt(new DateTime());
            $em->persist($data);
            $em->flush();
            
            return $this->redirectToRoute('app_annonce');
        }

        return $this->renderForm('annonce/form_annonce.html.twig', [
            'form' => $form,
            'createdAt' => $annonce->getCreatedAt()
        ]);
    }

     /**
     * Remove annonce  by Id
     * 
     * @Route("/delete/annonce/{id}", name="delete_annonce")
     * @param integer $id
     * @param EntityManagerInterface $em
     * @return Annonce
     */
    public function deleteAnnonce(int $id, EntityManagerInterface $em)
    {
        $annonce = $em->getRepository(Annonce::class)->find($id);

        if(!$annonce || $this->getUser() != $annonce->getAnnonceByUser()) 
        {
           throw $this->createNotFoundException('No annonce found'); 
        }

        $em->remove($annonce);
        $em->flush();    
        return $this->redirectToRoute('app_annonce');
    }
}
