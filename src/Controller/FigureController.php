<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Repository\FigureRepository;
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
     * @Route("/figure", name="afficher_figure")
     */
    public function afficherFigure(FigureRepository $repository, $id)
    {
        $figure = $repository->find($id);
        return $this->render('figure/afficherFigure.html.twig',[
            "figure" => $figure
        ]);
    }

}
