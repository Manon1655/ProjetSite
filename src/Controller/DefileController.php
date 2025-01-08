<?php

namespace App\Controller;


use App\Entity\Defile;
use App\Repository\DefileRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefileController extends AbstractController
{
    #[Route('/defiles', name: 'defiles' , methods:"GET")]

    public function listeDefiles(DefileRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $defiles=$paginator->paginate(
            $repo->listeDefilesCompletePaginee(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/defile/listeDefiles.html.twig', [
            'lesDefiles' => $defiles
        ]);
    }
        
    #[Route('/defile/{id}', name: 'ficheDefile' , methods:"GET")]

    public function ficheDefile(Defile $defile)
    {
        return $this->render('admin/defile/ficheDefile.html.twig', [
            'leDefile' => $defile
        ]);
    }
}