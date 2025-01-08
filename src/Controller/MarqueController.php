<?php

namespace App\Controller;


use App\Entity\Marque;
use App\Repository\MarqueRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarqueController extends AbstractController
{
    #[Route('/marque', name: 'admin_marque' , methods:"GET")]

    public function listeMarques(MarqueRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $marques=$paginator->paginate(
            $repo->listemarquesCompletePaginee(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/marques/listemarques.html.twig', [
            'lesmarques' => $marques
        ]);
    }
        
    #[Route('/marque/{id}', name: 'ficheMarque' , methods:"GET")]

    public function ficheMarque(Marque $marque)
    {
        return $this->render('marques/ficheMarque.html.twig', [
            'laMarque' => $marque
        ]);
    }
}