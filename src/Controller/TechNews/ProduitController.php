<?php

namespace App\Controller\TechNews;



use App\Controller\HelperTrait;
use App\Entity\Box;
use App\Entity\Fournisseur;
use App\Entity\Membre;
use App\Entity\Produit;
use App\Produit\ProduitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends Controller
{

    use HelperTrait;

    /**
     * Formulaire pour ajouter un Produit
     * @Route("/creer-un-produit",
     *     name="produit_new")
     * @Security("has_role('ROLE_ACHAT')")
     * @param Request $request
     * @return Response
     */
    public function newProduit(Request $request)
    {
        # Récupération d'un Membre
        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(2);

        $produit = new Produit();
        $produit->setMembre($membre);

        $form = $this->createForm(ProduitType::class, $produit)
            ->handleRequest($request);


        #->getForm();

        # Traitement des données POST
        # $form->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            # 2. Mise à jour du Slug
            $produit->setSlug($this->slugify($produit->getNom()));

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, ce produit est créé !');

            # 5. Redirection vers le produit créé
            return $this->redirectToRoute('index_produit', [
                'categorie' => $produit->getCategorie()->getSlug(),
                'slug' => $produit->getSlug(),
                'id' => $produit->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('produit/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}