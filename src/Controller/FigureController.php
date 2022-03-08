<?php

namespace App\Controller;

use DateTime;
use App\Entity\Figure;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Form\CommentaireFormType;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use App\Repository\UtilisateurRepository;
use Proxies\__CG__\App\Entity\Utilisateur;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FigureController extends AbstractController
{
    /**
     * @Route("/accueil", name="figures")
     */
    public function index(FigureRepository $repo, PaginatorInterface $paginatorInterface, Request $request)
    {
        $figures = $paginatorInterface->paginate(
            $repo->findAllWithPagination(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

     
        
        return $this->render('figure/figures.html.twig', [
            "figures" => $figures,
            "admin" => false
        ]);

    }

    /**
     * @Route("/figure/{slug}", name="afficher_figure")
     */
    public function afficherFigure(string $slug, Figure $figure,  FigureRepository $repo, Commentaire $commentaires, CacheInterface $cache, Request $request, EntityManagerInterface $em):Response
    {
        // // // $figure = $repo->findOneBy(['slug' => $slug]);
        // $figure = $cache->get('afficher_figure'.$slug, function(ItemInterface $item) use($repo, $slug){
        // $item->expiresAfter(20);
        // return $repo->findOneBy(['slug' => $slug]);
        // }
        
        // return $this->render('figure/afficherFigure.html.twig',[
        //     "figure" => $figure
        // ]);

            if(!$figure){
                $figure = new Figure();}
    //   //Partie slug

        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($figure->getNom());
     
        $slug = $this->generateUrl($slug,['slug' => $figure->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);

            // }
            
            $form = $this->createForm(FigureType::class,$figure);
            // $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                $form->handleRequest($request);
                $figure->getImage();
                $figure->getSlug();
            //   $figure->getCommentaires($commentaires);
                $em->persist($figure);
                $em->flush();  
                


                $url = $this->generateUrl("afficher_figure", array(
                "slug" => $slug
              ));
                // return $this->redirectToRoute("accueil");
                // return $this->redirectToRoute($this->generateUrl('figure/afficher_figure', array(
                // 'id' => $figure->getSlug(), UrlGeneratorInterface::ABSOLUTE_URL)));
                return $this->redirectToRoute('figure/afficher_figure', ['url'=>$url]);
            }       

          

            return $this->render('figure/afficher_figure',[
                // "slug" => $slug,
                "figure" => $figure,
                "form" => $form->createView()
            ]);

       
    
    } 

}
