<?php

namespace App\Controller;

use App\Entity\Mannequins;
use App\Repository\MannequinsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MannequinsController extends AbstractController
{
    #[Route('/mannequins', name: 'mannequins' , methods:"GET")]

    public function listeMannequins(MannequinsRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $mannequins=$paginator->paginate(
            $repo->listeMannequinsCompletePaginee(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/Mannequins/listeMannequins.html.twig', [
            'lesmannequins' => $mannequins
        ]);
    }
        
    #[Route('/mannequin/{id}', name: 'ficheMannequin' , methods:"GET")]

    public function ficheMannequin(Mannequins $mannequin)
    {
        return $this->render('Mannequin/ficheMannequin.html.twig', [
            'leMannequin' => $mannequin
        ]);
    }
}