<?php

namespace App\Controller;

use Swift_Message;
use App\Entity\Utilisateur;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use App\Security\UsersAuthenticator;
use Symfony\Component\Mailer\Mailer;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{
   
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, 
    GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, MailerInterface $mailer): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        dump($request->request->get('email'));
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles("ROLE_USER");

             // On génère un token et on l'enregistre
             $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // On crée le message   
            $mail = (new Email())
            ->from('mialy.razaf@gmail.com')
            ->to($user->getEmail())
            ->subject('Activation de votre compte')
            ->html(
                $this->renderView(
                    'emails/activation.html.twig', ['token' => $user->getActivationToken()]
                ),
                'text/html'
            )
         ;
   
         $mailer->send($mail);
         $this->addFlash('success', "Votre demande d'inscription a bien été enregistrée. Un email d'activation vous a été envoyé.");
         return $this->redirectToRoute('admin');
         
        }


        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre email a bien été vérifié.');

        return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UtilisateurRepository $users)
    {
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $user = $users->findOneBy(['activation_token' => $token]);

        // Si aucun utilisateur n'est associé à ce token
        if(!$user){
            // On renvoie une erreur 404
            // throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
             // On génère un message
        $this->addFlash('warning', 'Cet utilisateur n\'existe pas ou est déja activé');

        // On retourne à l'accueil
        return $this->redirectToRoute('app_register');
        }

         if ($user !== null){
        // On supprime le token
       $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
       
      
        // On génère un message
        $this->addFlash('success', 'Utilisateur activé avec succès');

        // On retourne à l'accueil
        return $this->redirectToRoute('login');
        }
    }

    
}