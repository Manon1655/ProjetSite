<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\FiltreBlogsType;
use App\Model\FiltreBlog;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog' , methods:"GET")]

    public function listeBlogs(BlogRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $filtre=new FiltreBlog();
        $formFiltreBlog=$this->createForm(FiltreBlogsType::class, $filtre);
        $formFiltreBlog->handleRequest($request);
        //  dd($filtre);
        $blogs=$paginator->paginate(
            $repo->listeBlogsCompletePaginee($filtre),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('/blog/listeBlogs.html.twig', [
            'lesBlogs' => $blogs,
            'formFiltreBlog'=>$formFiltreBlog->createView()
        ]);
    }

    #[Route('blog/ajout', name: 'blog_ajout' , methods:["GET","POST"])]
    #[Route('blog/modif/{id}', name: 'blog_modif' , methods:["GET","POST"])]

    public function ajoutModifBlog(Blog $blog=null, Request $request, EntityManagerInterface $manager, Security $security)
    {
        if($blog==null){
            $blog=new Blog();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }
        
        $user=$security->getUser();
        $blog->setUser($user);
        $form=$this->createForm(BlogType::class,$blog);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($blog);
            $manager->flush();
            $this->addFlash("success", "le blog a bien été $mode");
            return $this->redirectToRoute('blog');
        }
        return $this->render('blog/formAjoutModifBlog.html.twig', [
            'formBlog' => $form->createView()
        ]);
    }

    #[Route('blog/suppression/{id}', name: 'blog_suppression', methods: ["GET"])]
    public function suppressionBlog(Blog $blog, EntityManagerInterface $manager)
    {
            $manager->remove($blog);
            $manager->flush();
            $this->addFlash("success","le blog a bien été supprimé");
        
        return $this->redirectToRoute('blog');
    }
}
    

