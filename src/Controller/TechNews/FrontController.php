<?php

namespace App\Controller\TechNews;


use App\Article\Provider\YamlProvider;
use App\Entity\Article;
use App\Entity\Box;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends Controller
{
    /**
     * Page d'accueil de notre site internet
     * @param YamlProvider $yamlProvider
     * @return Response
     */
    public function index(YamlProvider $yamlProvider)
    {

        # Récupération des articles depuis le YamlProvider
        # $articles = $yamlProvider->getArticles();

        $repository = $this->getDoctrine()
            ->getRepository(Article::class);

        $articles = $repository->findBy([], ['id' => 'DESC']);
        $spotlight = $repository->findSpotlightArticles();

        # return new Response("<html><body><h1>PAGE D'ACCUEIL</h1></body></html>");
        return $this->render('front/index.html.twig', [
            'articles' => $articles,
            'spotlight' => $spotlight
        ]);
    }

    /**
     * Page permettant d'afficher les articles
     * d'une catégorie.
     * @Route("/categorie/{slug<[a-zA-Z1-9\-_\/]+>}",
     *     name="index_categorie",
     *     defaults={"slug":"breaking-news"},
     *     methods={"GET"},
     *     requirements={"slug":"\w+"})
     * @param $slug
     * @param Categorie $categorie
     * @return Response
     */
    public function categorie($slug, Categorie $categorie = null)
    {
        # return new Response("<html><body><h1>PAGE CATEGORIE : $slug</h1></body></html>");

        # Méthode 1 :
        # $categorie = $this->getDoctrine()
        #    ->getRepository(Categorie::class)
        #    ->findOneBy(['slug' => $slug]);
        # $articles = $categorie->getArticles();

        # Méthode 2 :
        # $articles = $this->getDoctrine()
        #     ->getRepository(Categorie::class)
        #     ->findOneBySlug($slug)
        #     ->getArticles();

        if (null === $categorie) {
            # Ou, on redirige l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('index', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Méthode 3 :
        return $this->render('front/categorie.html.twig', [
            'articles' => $categorie->getArticles(),
            'categorie' => $categorie
        ]);
    }

    /**
     * Afficher un Article
     * @Route("/{categorie<\w+>}/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
     *     name="index_article")
     * @param $id
     * @param $slug
     * @param $categorie
     * @param Article $article
     * @return Response
     */
    public function article($id,
                            $slug,
                            $categorie,
                            Article $article = null)
    {
        # Exemple d'URL
        # politique/les-gilets-jaunes-mettent-le-feu-a-l-elysee_684651.html

        # $article = $this->getDoctrine()
        #     ->getRepository(Article::class)
        #     ->find($id);

        # On s'assure que l'article ne soit pas null.
        if (null === $article) {

            # On génère une exception
            # throw $this->createNotFoundException(
            #     "Nous n'avons pas trouvé votre article ID : " . $id
            # );

            # Ou, on redirige l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('index', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Vérification du SLUG
        if ($article->getSlug() !== $slug
            || $article->getCategorie()->getSlug() !== $categorie) {
            return $this->redirectToRoute('index_article', [
                'categorie' => $article->getCategorie()->getSlug(),
                'slug' => $article->getSlug(),
                'id' => $id
            ]);
        }

        # Récupération des suggestions
        $suggestions = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findArticlesSuggestions($article->getId(), $article->getCategorie()->getId());

        # Transmission des données à la vue
        return $this->render('front/article.html.twig', [
            'article' => $article,
            'suggestions' => $suggestions
        ]);
    }

    /**
 * Afficher un Fournisseur
 * @Route("/{categorie<\w+>}/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
 *     name="index_fournisseur")
 * @param $id
 * @param $slug
 * @param $categorie
 * @param Fournisseur $fournisseur
 * @return Response
 */
    public function fournisseur($id,
                                $slug,
                                $categorie,
                                Fournisseur $fournisseur = null)
    {
        # Exemple d'URL
        # politique/les-gilets-jaunes-mettent-le-feu-a-l-elysee_684651.html

        # $article = $this->getDoctrine()
        #     ->getRepository(Article::class)
        #     ->find($id);

        # On s'assure que l'article ne soit pas null.
        if (null === $fournisseur) {

            # On génère une exception
            # throw $this->createNotFoundException(
            #     "Nous n'avons pas trouvé votre article ID : " . $id
            # );

            # Ou, on redirige l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('index', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Vérification du SLUG
        if ($fournisseur->getSlug() !== $slug
            || $fournisseur->getCategorie()->getSlug() !== $categorie) {
            return $this->redirectToRoute('index_fournisseur', [
                'categorie' => $fournisseur->getCategorie()->getSlug(),
                'slug' => $fournisseur->getSlug(),
                'id' => $id
            ]);
        }

        # Récupération des suggestions
        #$suggestions = $this->getDoctrine()
        #    ->getRepository(Fournisseur::class);
        #->findArticlesSuggestions($article->getId(), $article->getCategorie()->getId());

        # Transmission des données à la vue
        return $this->render('front/fournisseur.html.twig', [
            'fournisseur' => $fournisseur
            #'suggestions' => $suggestions
        ]);
    }

    /**
     * Afficher une Box
     * @Route("/{categorie<\w+>}/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
     *     name="index_box")
     * @param $id
     * @param $slug
     * @param $categorie
     * @param Box $box
     * @return Response
     */
    public function box($id,
                        $slug,
                        $categorie,
                        Box $box = null)
    {
        # Exemple d'URL
        # politique/les-gilets-jaunes-mettent-le-feu-a-l-elysee_684651.html

        # $article = $this->getDoctrine()
        #     ->getRepository(Article::class)
        #     ->find($id);

        # On s'assure que l'article ne soit pas null.
        if (null === $box) {

            # On génère une exception
            # throw $this->createNotFoundException(
            #     "Nous n'avons pas trouvé votre article ID : " . $id
            # );

            # Ou, on redirige l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('index', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Vérification du SLUG
        if ($box->getSlug() !== $slug
            || $box->getCategorie()->getSlug() !== $categorie) {
            return $this->redirectToRoute('index_box', [
                'categorie' => $box->getCategorie()->getSlug(),
                'slug' => $box->getSlug(),
                'id' => $id
            ]);
        }

        # Récupération des suggestions
        #$suggestions = $this->getDoctrine()
        #    ->getRepository(Box::class);
        #->findArticlesSuggestions($article->getId(), $article->getCategorie()->getId());

        # Transmission des données à la vue
        return $this->render('front/box.html.twig', [
            'box' => $box
            #'suggestions' => $suggestions
        ]);
    }

    /**
     * Afficher un produit
     * @Route("/{categorie<\w+>}/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
     *     name="index_produit")
     * @param $id
     * @param $slug
     * @param $categorie
     * @param Produit $produit
     * @return Response
     */
    public function produit($id,
                        $slug,
                        $categorie,
                        Produit $produit = null)
    {
        # Exemple d'URL
        # politique/les-gilets-jaunes-mettent-le-feu-a-l-elysee_684651.html

        # $article = $this->getDoctrine()
        #     ->getRepository(Article::class)
        #     ->find($id);

        # On s'assure que l'article ne soit pas null.
        if (null === $produit) {

            # On génère une exception
            # throw $this->createNotFoundException(
            #     "Nous n'avons pas trouvé votre article ID : " . $id
            # );

            # Ou, on redirige l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('index', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Vérification du SLUG
        if ($produit->getSlug() !== $slug
            || $produit->getCategorie()->getSlug() !== $categorie) {
            return $this->redirectToRoute('index_produit', [
                'categorie' => $produit->getCategorie()->getSlug(),
                'slug' => $produit->getSlug(),
                'id' => $id
            ]);
        }

        # Récupération des suggestions
        #$suggestions = $this->getDoctrine()
        #    ->getRepository(Produit::class);
        #->findArticlesSuggestions($article->getId(), $article->getCategorie()->getId());

        # Transmission des données à la vue
        return $this->render('front/produit.html.twig', [
            'produit' => $produit
            #'suggestions' => $suggestions
        ]);
    }

    /**
     * Gérer l'affichage de
     * la sidebar
     * @param Article|null $article
     * @return Response
     */
    public function sidebar(?Article $article = null)
    {
        # Récupération du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);

        # Récupérer les 5 derniers articles
        $articles = $repository->findLatestArticles();

        # Récupérer les articles à la position "special"
        $specials = $repository->findSpecialArticles();

        # Rendu de la vue
        return $this->render('components/_sidebar.html.twig', [
            'articles' => $articles,
            'specials' => $specials,
            'article' => $article
        ]);
    }
}