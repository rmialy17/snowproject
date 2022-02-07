<?php

namespace App\Controller;

use DateTime;
use App\Entity\Figure;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{
    /**
     * @Route("/accueil", name="figures")
     */
    public function index(FigureRepository $repo,PaginatorInterface $paginatorInterface, Request $request)
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
     * @Route("/figure/{id}", name="afficher_figure")
     */
    public function afficherFigure(Figure $figure,  Request $request, EntityManagerInterface $em):Response
    {
        return $this->render('figure/afficherFigure.html.twig',[
            "figure" => $figure
        ]);

        // Partie commentaires
        // On crée le commentaire "vierge"
        
            if(!$figure){
                $figure = new Figure();
            }
            
            $form = $this->createForm(FigureType::class,$figure);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                $em->persist($figure);
                $em->flush();
                $this->addFlash('success', "L'action a été effectuée");
                return $this->redirectToRoute("accueil");
            }
    
            return $this->render('figure/afficherFigure.html.twig',[
                "figure" => $figure,
                "form" => $form->createView()
            ]);
        }
    

}
