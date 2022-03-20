<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Figure;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @Route("/admin/creation", name="creationFigure", methods="GET|POST")
     */
    public function creation(UserInterface $user,  Figure $figure= null, Request $request, EntityManagerInterface $em) : Response{
      
      
            $figure = new Figure();
            $figure->getNom();
            $figure->getCategorie();
            $figure->getDescription();
            
            $form = $this->createForm(FigureType::class,$figure);
            $form->handleRequest($request);
    
            $nom = $form->get('nom')->getData();
            $categorie= $form->get('categorie')->getData();
            $description= $form->get('description')->getData();
            $imagetop_upload= $form->get('imagetop_upload')->getData();

            // dd($imagetop_upload);
            if($form->isSubmitted() && $form->isValid()){

             $figure->setUser($user);
             $figure->setNom($nom);
             $figure->setCategorie($categorie);
             $figure->setDescription($description);

             $slugger = new AsciiSlugger();    
             $figure->setSlug($slugger->slug(strtolower($figure->getNom())));  
              
                 $imagetop_upload= $form->get('imagetop_upload')->getData();
                 // On génère un nouveau nom de fichier
                 if($imagetop_upload !== null){
                //  $imagetop=$imagetop_upload;
                 $fichier1 = md5(uniqid()) . '.' . $imagetop_upload->guessExtension();
                 // On copie le fichier dans le dossier uploads
                 $imagetop_upload->move(
                     $this->getParameter('images_directory'),
                     $fichier1
                 );
                
                 // On stocke l'image principale dans la base de données (son nom)
                 $figure->setImagetop($fichier1);
                } 


                // On récupère les images multiples transmises
                $images = $form->get('images')->getData();
    
                // On boucle sur les images
                if($images !== null){
                foreach($images as $image){
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()) . '.' . $image->guessExtension();
    
                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
    
                    // On stocke l'image dans la base de données (son nom)
                    $img = new Image();
                    $img->setName($fichier);
                    $figure->addImage($img);
                 }
                }
             
                 // On récupère la video transmise
                $video = $form->get('videos')->getData();   
                // foreach($videos as $video){
                if($video !== null){
                 // On stocke la video dans la base de données
                $vid= new Video();
                $vid->setURL($video);
                $figure->addVideo($vid);
               }
                if ($imagetop_upload !== null){
                $em->persist($figure);
                $em->flush();
                $this->addFlash('success', "La figure a bien a été ajoutée.");
                return $this->redirectToRoute('admin');
            }else{
                $this->addFlash('success', "Echec de l'ajout. Veuillez ajouter une image principale à votre figure");
                return $this->redirectToRoute('admin');
            }
        }


        return $this->render('admin/creation.html.twig',[
            "figure" => $figure,
            "user" => $user,
            "form" => $form->createView()
        ]);
    }

    
    /**
     * @Route("/modifierFigure/{slug}", name="modifFigure", methods="GET|POST")
     */
    public function modification(UserInterface $user, Figure $figure= null, Request $request, EntityManagerInterface $em) : Response{


        if(!$figure){
            $figure = new Figure();
        } 
        $form = $this->createForm(FigureType::class,$figure);
        $form->handleRequest($request);  
        $figure->getNom();  
        // $nom=$form->get('nom')->getData();  
        $categorie=$form->get('categorie')->getData();
        $description=$form->get('description')->getData();
        $figure->getImagetop();
        
        if($form->isSubmitted() && $form->isValid()){

        $figure->setUser($user);
        $figure->getId();
     
        $figure->getNom(); 
        $figure->setCategorie($categorie);

         $slugger = new AsciiSlugger();    
         $figure->setSlug($slugger->slug(strtolower($figure->getNom())));  
          
         $imagetop_upload= $form->get('imagetop_upload')->getData();   
         $imagetop=$figure->getImagetop();
        if($imagetop_upload !== null){
        $imagetop_upload; 
        // $imagetop_upload->setImagetopUpload();    
        $fichier1 = md5(uniqid()) . '.' . $imagetop_upload->guessExtension();
        // On copie le fichier dans le dossier uploads
        $imagetop_upload->move(
            $this->getParameter('images_directory'),
            $fichier1
        );
  
        // On stocke l'image principale dans la base de données (son nom) 
        $figure->setImagetopUpload($fichier1);
        $imagetop_upload=$figure->setImagetop($fichier1);    
        } 
 
            // On récupère les images multiples transmises
            $images = $form->get('images')->getData();

            if($images !== null){

            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke les images dans la base de données (leurs noms)
                $img = new Image();
                $img->setName($fichier);
                $figure->addImage($img);
                }
            }
             // On récupère la video transmise
            $video = $form->get('videos')->getData();

             // On stocke la video dans la base de données
             if($video !== null){
            $vid = new Video();
            $vid->setURL($video);
            $figure->addVideo($vid);
             }
             
            $em->persist($figure);
            $em->flush();
            $this->addFlash('success', "La modification a bien été enregistrée.");
            return $this->redirectToRoute("admin");
      
           }  

        return $this->render('admin/modification.html.twig',[
            "figure" => $figure,
            "user" => $user,
            "form" => $form->createView()
        ]);   
         
    }

     /**
     * @Route("/admin/suppr/{id}", name="supFigure", methods={"SUP"})
     */
    public function suppression(Figure $figure, Request $request, EntityManagerInterface $em) {
        if($this->isCsrfTokenValid("SUP".$figure->getId(),$request->get("_token"))){
            $em->remove($figure);
            $em->flush();
            $this->addFlash('success', "La suppression a été effectuée"); 
            return $this->redirectToRoute("admin");   
         }
    }

    /**
     * @Route("/image_delete/{image_id}", name="image_delete", methods={"DELETE"})
     * @ParamConverter("image", options={"id" = "image_id"})
     */
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $em) : Response{
      
        if($this->isCsrfTokenValid('image_delete'.$image->getId(), $request->get("_token"))){
            // if($this->isCsrfTokenValid("SUP".$image->getId(), $request->get("_token"))){
            $em->remove($image);
            $em->flush();
            $this->addFlash('success', "La suppression a été effectuée"); 
            return $this->redirectToRoute("admin");   
         }
    }

     /**
     * @Route("/video_delete/{video_id}", name="video_delete", methods={"DELETE"})
     * @ParamConverter("video", options={"id" = "video_id"})
     */
    public function deleteVideo(Video $video, Request $request, EntityManagerInterface $em) : Response{
      
        if($this->isCsrfTokenValid('video_delete'.$video->getId(), $request->get("_token"))){
            // if($this->isCsrfTokenValid("SUP".$image->getId(), $request->get("_token"))){
            $em->remove($video);
            $em->flush();
            $this->addFlash('success', "La suppression a été effectuée"); 
            return $this->redirectToRoute("admin");   
         }
    }

    
}