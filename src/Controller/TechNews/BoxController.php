<?php

namespace App\Controller\TechNews;



use App\Box\BoxType;
use App\Controller\HelperTrait;
use App\Entity\Box;
use App\Entity\Membre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoxController extends Controller
{

    use HelperTrait;

    /**
     * Formulaire pour ajouter une box
     * @Route("/creer-une-box",
     *     name="box_new")
     * @Security("has_role('ROLE_MARKETING')")
     * @param Request $request
     * @return Response
     */
    public function newBox(Request $request)
    {
        # Récupération d'un Membre
        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(2);

        $box = new Box();
        $box->setMembre($membre);

        $form = $this->createForm(BoxType::class,$box)
            ->handleRequest($request);


        #->getForm();

        # Traitement des données POST
        # $form->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if( $form->isSubmitted() && $form->isValid() ) {

            # 2. Mise à jour du Slug
            $box->setSlug($this->slugify($box->getNom()));

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($box);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, cette box est créée !');

            # 5. Redirection vers la box créée
            return $this->redirectToRoute('index_box', [
                'categorie' => $box->getCategorie()->getSlug(),
                'slug' => $box->getSlug(),
                'id' => $box->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('box/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}