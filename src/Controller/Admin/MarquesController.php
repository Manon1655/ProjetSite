<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Repository\MarqueRepository;
use App\Controller\MarquesController;
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
            'lesMarques' => $marques
        ]);
    }
    #[Route('/admin/marque/ajout', name: 'admin_marque_ajout' , methods:["GET","POST"])]
    #[Route('/admin/marque/modif/{id}', name: 'admin_marque_modif' , methods:["GET","POST"])]

    public function ajoutModifMarque(Marque $marque=null, Request $request, EntityManagerInterface $manager)
    {
        if($marque==null){
            $marque=new Marque();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }

        $form=$this->createForm(MarqueType::class,$marque);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($marque);
            $manager->flush();
            $this->addFlash("success", "la marque a bien été $marque");
            return $this->redirectToRoute('admin_marques');
        }
        return $this->render('admin/marque/formAjoutModifmarque.html.twig', [
            'formMarque' => $form->createView()
        ]);
    }

    #[Route('/admin/marque/suppression/{id}', name: 'admin_marque_suppression', methods: ["GET"])]
    public function suppressionmarque(Marque $marque, EntityManagerInterface $manager)
    {
            $manager->remove($marque);
            $manager->flush();
            $this->addFlash("success","la marque a bien été supprimé");
        
        return $this->redirectToRoute('admin_marques');
    }
}