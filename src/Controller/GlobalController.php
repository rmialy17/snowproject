<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('global/accueil.html.twig');
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class,$utilisateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $passwordCrypte = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($passwordCrypte);
            $utilisateur->setRoles("ROLE_USER");
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success', "L'inscription a été effectuée"); 
            return $this->redirectToRoute("accueil");
        }

        return $this->render('global/inscription.html.twig',[
            "form" => $form->createView()
        ]);
    }

        /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $util){
        return $this->render('global/login.html.twig',[
            "lastUserName" => $util->getLastUsername(),
            "error" => $util->getLastAuthenticationError(),   
            $this->addFlash('success', "Connexion réussie."),
        ]);
     
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        return $this->render('global/accueil.html.twig',[  
        $this->addFlash('success', "Déconnexion réussie.")   
    ]);
        return $this->redirectToRoute("accueil");
    }

   
}
