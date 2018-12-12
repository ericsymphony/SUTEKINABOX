<?php

namespace App\Controller\TechNews;



use App\Controller\HelperTrait;
use App\Entity\Fournisseur;
use App\Entity\Membre;
use App\Fournisseur\FournisseurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FournisseurController extends Controller
{

    use HelperTrait;

    /**
     * Formulaire pour ajouter un Fournisseur
     * @Route("/creer-un-fournisseur",
     *     name="fournisseur_new")
     * @Security("has_role('ROLE_ACHAT')")
     * @param Request $request
     * @return Response
     */
    public function newFournisseur(Request $request)
    {
        # Récupération d'un Membre
        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(2);

        $fournisseur = new Fournisseur();
        $fournisseur->setMembre($membre);

        $form = $this->createForm(FournisseurType::class,$fournisseur)
            ->handleRequest($request);


        #->getForm();

        # Traitement des données POST
        # $form->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if( $form->isSubmitted() && $form->isValid() ) {

            # 2. Mise à jour du Slug
            $fournisseur->setSlug($this->slugify($fournisseur->getNom()));

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, ce fournisseur est créé !');

            # 5. Redirection vers l'article créé
            return $this->redirectToRoute('index_fournisseur', [
                'categorie' => $fournisseur->getCategorie()->getSlug(),
                'slug' => $fournisseur->getSlug(),
                'id' => $fournisseur->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('fournisseur/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


}