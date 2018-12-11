<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 06/12/2018
 * Time: 10:06
 */

namespace App\Controller\TechNews\Security;


use App\Membre\MembreLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{


    /**
     * Connexion d'un Membre
     * @Route("/connexion", name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils): Response

    {

        /**
         * Si notre untilisateur est deja authentifie
         * on le redirige sur la page d'accuil
         *
         */


        if($this->getUser())  {
            return $this->redirectToRoute('index');
        }

        // Recupiration du formulaire de Connexion

        $form = $this->createForm(MembreLoginType::class,

            [
                'email' => $authenticationUtils->getLastUsername()
            ]);


        // get the login error if there is one

        $error = $authenticationUtils->getLastAuthenticationError();

        // $lastUsername = $authenticationUtils->getLastUsername();


        // Transmission a la Vue


        // return $this->redirectToRoute('index');

        return $this->render('security/connexion.html.twig',

            [
                'form'=>$form->createView(),
                'error' => $error
            ]);


    }


    /**
     *
     * Deconnexion dun Membre
     * @Route("/deconnexion", name="security_deconnexion")
     *
     */

    public function deconnexion()
    {

    }




}