<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/12/2018
 * Time: 12:07
 */

namespace App\Controller\TechNews;


use App\Entity\Membre;
use App\Membre\MembreType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class MembreController extends Controller
{
    /**
     *@Route("/inscription",
     *     methods={"GET", "POST"},
     *    name="membre_inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        # Création d'un membre vide
        $membre = new Membre();
        #$membre->setRoles('ROLE_MEMBRE');

        # Créer un Formulaire permettant l'ajout d'un Auteur
        $form = $this->createForm(MembreType::class, $membre);

        # Traitement des données POST
        $form->handleRequest($request);
        # Vérification des données du Formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password (you could also do this via Doctrine listener)
            #$password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $membre->setPassword($passwordEncoder
                ->encodePassword($membre, $membre->getPassword()));

            // save the User!
            #$entityManager = $this->getDoctrine()->getManager();
            #$entityManager->persist($user);
            #$entityManager->flush();
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            $this->addFlash('notice',
                'Félicitations connecté !');

            return $this->redirectToRoute('security_connexion');

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            #return $this->redirectToRoute('replace_with_some_route');

        }

        # Affichage du Formulaire dans la Vue
        return $this->render(
            'membre/inscription.html.twig', [
            'form' => $form->createView()
        ]);

    }


}