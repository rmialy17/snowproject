<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(FigureRepository $repo,PaginatorInterface $paginatorInterface, Request $request): Response
    {   $figures = $paginatorInterface->paginate(
        $repo->findAllWithPagination(),
        $request->query->getInt('page', 1), /*page number*/
        6 /*limit per page*/
    );
    return $this->render('figure/figures.html.twig',[
        "figures" => $figures,
        "admin" => true
    ]);
    }
    
    /**
     * @Route("/admin/creation", name="creationFigure")
     * @Route("/admin/{id}", name="modifFigure", methods="GET|POST")
     */
    public function modification(Figure $figure= null, Request $request, EntityManagerInterface $em) : Response{
        if(!$figure){
            $figure = new Figure();
        }
        
        $form = $this->createForm(FigureType::class,$figure);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($figure);
            $em->flush();
            $this->addFlash('success', "L'action a été effectuée");
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/modification.html.twig',[
            "figure" => $figure,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="supFigure", methods="SUP")
     */
    public function suppression(Figure $figure, Request $request, EntityManagerInterface $em): Response {
        if($this->isCsrfTokenValid("SUP".$figure->getId(), $request->get("_token"))){
            $em->remove($figure);
            $em->persist($figure);
            $em->flush();
            $this->addFlash('success', "L'action a été effectuée"); 
            return $this->redirectToRoute("admin");   
    }
   
        }
}