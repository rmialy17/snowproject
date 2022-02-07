<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ResetPassType;
use App\Form\InscriptionType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('global/accueil.html.twig');
    }

    // /**
    //  * @Route("/inscription", name="inscription")
    //  */
    // public function inscription(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){
    //     $utilisateur = new Utilisateur();
    //     $form = $this->createForm(InscriptionType::class,$utilisateur);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){
    //         $passwordCrypte = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
    //         $utilisateur->setPassword($passwordCrypte);
    //         $utilisateur->setRoles("ROLE_USER");
    //         $em->persist($utilisateur);
    //         $em->flush();
    //         $this->addFlash('success', "L'inscription a été effectuée"); 
    //         return $this->redirectToRoute("accueil");
    //     }

    //     return $this->render('global/inscription.html.twig',[
    //         "form" => $form->createView()
    //     ]);
    // }

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
        return $this->render('global/login.html.twig',[
            $this->addFlash('success', "Déconnexion réussie."),
        ]);
        return $this->redirectToRoute("login");
    }

        /**
     * @Route("/oubli-pass", name="app_forgotten_password")
     */
    public function oubliPass(Request $request, UtilisateurRepository $users, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator
    ): Response
    {
        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();

            // On cherche un utilisateur ayant cet e-mail
            $user = $users->findOneByEmail($donnees['email']);

            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');
                
                // On retourne sur la page de connexion
                return $this->redirectToRoute('app_login');
            }

            // On génère un token
            $token = $tokenGenerator->generateToken();

            // On essaie d'écrire le token en base de données
            try{
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('login');
            }

            // On génère l'URL de réinitialisation de mot de passe
            // $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // On génère l'e-mail
            $message = (new Email())
            ->from('mialy.razaf@gmail.com')
            ->to($user->getEmail())
            ->subject('Mot de passe oublié')
            // ->html(
            //     "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Snowtricks.com. Veuillez cliquer sur le lien suivant : " . $url,
            //     'text/html',
            //     $this->$this->renderView(
            //         'security/reset_password.html.twig', array('token' => $token))
            // )
            ->html(
                $this->renderView(
                    'emails/reset_password_email.html.twig', ['token'=> $token]
                ),
                'text/html'
            )
         
            ;

            // On envoie l'e-mail
            $mailer->send($message);

            // On crée le message flash de confirmation
            $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

            // On redirige vers la page de login
            return $this->redirectToRoute('login');
        }

        // On envoie le formulaire à la vue
        return $this->render('security/forgotten_password.html.twig',['emailForm' => $form->createView()]);
    }

     /**
     * @Route("/reset_pass/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        // On cherche un utilisateur avec le token donné
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['reset_token' => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('login');
        }

        // Si le formulaire est envoyé en méthode post
        if ($request->isMethod('POST')) {
            // On supprime le token
            $user->setResetToken(null);

            // On chiffre le mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            // On stocke
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On crée le message flash
            $this->addFlash('message', 'Mot de passe mis à jour');

            // On redirige vers la page de connexion
            return $this->redirectToRoute('login');
        }else {
            // Si on n'a pas reçu les données, on affiche le formulaire
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }

    }

}
