<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Repository\MarqueRepository;
use App\Form\MarquesType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarquesController extends AbstractController
{
    #[Route('admin/marques', name: 'admin_marques' , methods:"GET")]
    public function listeMarques(MarqueRepository $repo , PaginatorInterface $paginator, Request $request)
    
    {
        $marques= $paginator->paginate(
        $repo->listeMarquesCompletePaginee(),
        $request->query->getInt('page', 1),
        9
        );
        return $this->render('admin/marques/listeMarques.html.twig', [
            'lesmarques' => $marques
        ]);
    }
    #[Route('/admin/marques/ajout', name: 'admin_marques_ajout' , methods:["GET","POST"])]
    #[Route('/admin/marque/modif/{id}', name: 'admin_marques_modif' , methods:["GET","POST"])]

    public function ajoutModifMarque(Marque $marque=null, Request $request, EntityManagerInterface $manager)
    {
        if($marque==null){
            $marque=new Marque();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }

        $form=$this->createForm(MarquesType::class,$marque);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($marque);
            $manager->flush();
            $this->addFlash("success", "la marque a bien été $marque");
            return $this->redirectToRoute('admin_marques');
        }
        return $this->render('admin/marques/formAjoutModifmarques.html.twig', [
            'formMarque' => $form->createView()
        ]);
    }

    #[Route('/admin/marques/suppression/{id}', name: 'admin_marques_suppression', methods: ["GET"])]
    public function suppressionmarque(Marque $marque, EntityManagerInterface $manager)
    {
            $manager->remove($marque);
            $manager->flush();
            $this->addFlash("success","la marque a bien été supprimé");
        
        return $this->redirectToRoute('admin_marques');
    }

    public function index(Request $request, MarqueRepository $MarqueRepository, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search', '');

        $query = $search 
            ? $MarqueRepository->findBySearchQuery($search) 
            : $MarqueRepository->findAllQuery();
        $lesmarques = $paginator->paginate(
            $query, 
            $request->query->getInt('page', 1), 
            9 
        );

        return $this->render('marque/listeMarques.html.twig', [
            'lesmarques' => $lesmarques,
        ]);
    }
}
