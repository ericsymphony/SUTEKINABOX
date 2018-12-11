<?php

namespace App\Controller\TechNews;


use App\Article\ArticleType;
use App\Controller\HelperTrait;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Membre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    use HelperTrait;

    /**
     * Démonstration de l'ajout
     * d'un article avec Doctrine.
     * @Route("test/ajouter-un-article",
     *     name="article_test")
     */
    public function test()
    {
        # Création d'une Catégorie
        $categorie = new Categorie();
        $categorie->setNom('Politique');
        $categorie->setSlug('politique');

        # Création d'un Membre (Auteur de l'article)
        $membre = new Membre();
        $membre
            ->setPrenom('Hugo')
            ->setNom('LIEGEARD')
            ->setEmail('hugo.liegeard@tech.news')
            ->setPassword('test')
            ->setRoles(['ROLE_AUTEUR'])
        ;

        # Création de l'article

        # On sauvegarde le tout avec Doctrine
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->persist($membre);
       # $em->persist($article);
        $em->flush();

        # Affichage d'une réponse.
        return new Response(
          'Nouvel Article ID : '
          #. $article->getId()
          . ' dans la catégorie : '
          . $categorie->getNom()
          . ' de l\'auteur : '
          . $membre->getPrenom()
        );
    }

    /**
     * Formulaire pour ajouter un Article
     * @Route("/creer-un-article",
     *     name="article_new")
     * @Security("has_role('ROLE_AUTEUR')")
     * @param Request $request
     * @return Response
     */
    public function newArticle(Request $request)
    {
        # Récupération d'un Membre
        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(2);

        $article = new Article();
        $article->setMembre($membre);

        $form = $this->createForm(ArticleType::class,$article)
                ->handleRequest($request);


        #->getForm();

        # Traitement des données POST
       # $form->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if( $form->isSubmitted() && $form->isValid() ) {

            #dump($article);
            # 1. Traitement de l'upload de l'image

             /** @var UploadedFile $featuredImage */
            $featuredImage = $article->getFeaturedImage();

            $fileName = $this->slugify($article->getTitre())
                . '.' . $featuredImage->guessExtension();

            try {
                $featuredImage->move(
                    $this->getParameter('articles_assets_dir'),
                    $fileName
                );
            } catch (FileException $e) {

            }

            # Mise à jour de l'image
            $article->setFeaturedImage($fileName);

            # 2. Mise à jour du Slug
            $article->setSlug($this->slugify($article->getTitre()));

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, votre article est en ligne !');

            # 5. Redirection vers l'article créé
            return $this->redirectToRoute('index_article', [
               'categorie' => $article->getCategorie()->getSlug(),
               'slug' => $article->getSlug(),
               'id' => $article->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('article/form.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editer-un-article/{id<\d+>}",
     *     name="article_edit")
     * @Security("article.isAuteur(user)")
     * @param Article $article
     * @param Request $request
     * @param Packages $packages
     * @return Response
     */
    public function editArticle(Article $article,
                                Request $request,
                                Packages $packages)
    {

        # On passe à notre formulaire l'URL de la featuredImage
        $options = [
            'image_url' => $packages->getUrl('images/product/'
                . $article->getFeaturedImage())
        ];

        # Récupération de l'image
        $featuredImageName = $article->getFeaturedImage();

        # Notre formulaire attend une instance de File pour l'edition
        # de la featuredImage
        $article->setFeaturedImage(
            new File($this->getParameter('articles_assets_dir')
                . '/' . $featuredImageName)
        );

        # Création / Récupération du Formulaire
        $form = $this->createForm(ArticleType::class, $article, $options)
            ->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            #dump($article);
            # 1. Traitement de l'upload de l'image

            /** @var UploadedFile $featuredImage */
            $featuredImage = $article->getFeaturedImage();

            if (null !== $featuredImage) {

                $fileName = $this->slugify($article->getTitre())
                    . '.' . $featuredImage->guessExtension();

                try {
                    $featuredImage->move(
                        $this->getParameter('articles_assets_dir'),
                        $fileName
                    );
                } catch (FileException $e) {

                }

                # Mise à jour de l'image
                $article->setFeaturedImage($fileName);

            } else {
                $article->setFeaturedImage($featuredImageName);
            }

            # 2. Mise à jour du Slug
            $article->setSlug($this->slugify($article->getTitre()));

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, votre article est en ligne !');

            # 5. Redirection vers l'article créé
            return $this->redirectToRoute('article_edit', [
                'id' => $article->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('article/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}