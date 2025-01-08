<?php

namespace App\Controller\Admin;

use App\Entity\Defile;
use App\Form\DefileType;
use App\Repository\DefileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefileController extends AbstractController
{
    /**
     * Liste paginée des défilés
     */
    #[Route('/admin/defiles', name: 'admin_defiles', methods: ['GET'])]
    public function listeDefiles(DefileRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $defiles = $paginator->paginate(
            $repo->listeDefilesCompletePaginee(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('admin/defile/listeDefiles.html.twig', [
            'lesDefiles' => $defiles,
        ]);
    }

    /**
     * Ajouter ou modifier un défilé
     */
    #[Route('/admin/defile/ajout', name: 'admin_defile_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/defile/modif/{id?}', name: 'admin_defile_modif', methods: ['GET', 'POST'])]
    public function ajoutModifDefile(?Defile $defile, Request $request, EntityManagerInterface $manager): Response
    {
        $mode = $defile ? 'modifié' : 'ajouté';
        $defile = $defile ?? new Defile();

        $form = $this->createForm(DefileType::class, $defile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($defile);
            $manager->flush();

            $this->addFlash('success', "Le défilé a bien été $mode.");
            return $this->redirectToRoute('admin_defiles');
        }

        return $this->render('admin/defile/formAjoutModifDefile.html.twig', [
            'formDefile' => $form->createView(),
        ]);
    }

    /**
     * Supprimer un défilé
     */
    #[Route('/admin/defile/suppression/{id}', name: 'admin_defile_suppression', methods: ['GET'])]
    public function suppressionDefile(Defile $defile, EntityManagerInterface $manager): Response
    {
        $manager->remove($defile);
        $manager->flush();

        $this->addFlash('success', 'Le défilé a bien été supprimé.');
        return $this->redirectToRoute('admin_defiles');
    }

    /**
     * Page d'accueil avec filtres pour les défilés
     */
    #[Route('/admin/defile', name: 'defile_index', methods: ['GET'])]
    public function index(Request $request, DefileRepository $repository): Response
    {
        $search = $request->query->get('search', '');
        $mannequin = $request->query->get('mannequin', null);
        $annee = $request->query->get('annee', null);

        if ($mannequin && !is_numeric($mannequin)) {
            throw new \InvalidArgumentException('Le paramètre mannequin doit être un entier.');
        }

        if ($annee && (!is_numeric($annee) || strlen($annee) !== 4)) {
            throw new \InvalidArgumentException('Le paramètre année doit être une année valide.');
        }

        $queryBuilder = $repository->createQueryBuilder('d')
            ->leftJoin('d.mannequin', 'm') 
            ->addSelect('m');

        if (!empty($search)) {
            $queryBuilder->andWhere('d.nomD LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($mannequin) {
            $queryBuilder->andWhere('m.id = :mannequin')
                ->setParameter('mannequin', $mannequin);
        }

        if ($annee) {
            $queryBuilder->andWhere('YEAR(d.date) = :annee')
                ->setParameter('annee', $annee);
        }

        $lesDefiles = $queryBuilder->getQuery()->getResult();

        return $this->render('defile/index.html.twig', [
            'lesDefiles' => $lesDefiles,
            'search' => $search,
            'mannequin' => $mannequin,
            'annee' => $annee,
        ]);
    }
}
