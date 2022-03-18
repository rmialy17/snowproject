<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Commentaire;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
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
    public function afficherFigure(string $slug, Figure $figure, Request $request, EntityManagerInterface $em):Response
    {

            if(!$figure){
                $figure = new Figure();}

        //Partie slug
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($figure->getNom());
        $slug = $this->generateUrl($slug,['slug' => $figure->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);
            
            $form = $this->createForm(FigureType::class,$figure);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){

//                 $form->handleRequest($request);

                $figure->getImage();
                $figure->getSlug();
    
                $em->persist($figure);
                $em->flush();  
                
                $url = $this->generateUrl("afficher_figure", array(
                "slug" => $slug
              ));
               
                return $this->redirectToRoute('figure/afficher_figure', ['url'=>$url]);
            }       

          

            return $this->render('figure/afficher_figure',[
                "figure" => $figure,
                "form" => $form->createView()
            ]);

       
    
    } 

}
