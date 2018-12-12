<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article",
     *     mappedBy="categorie")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fournisseur",
     *     mappedBy="categorie")
     */
    private $fournisseurs;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit",
     *     mappedBy="categorie")
     */
    private $produits;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Box",
     *     mappedBy="categorie")
     */
    private $boxs;


    /**
     * Categorie constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->boxs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles): void
    {
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getFournisseurs()
    {
        return $this->fournisseurs;
    }

    /**
     * @param mixed $fournisseurs
     */
    public function setFournisseurs($fournisseurs): void
    {
        $this->fournisseurs = $fournisseurs;
    }

    /**
     * @return mixed
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * @param mixed $produits
     */
    public function setProduits($produits): void
    {
        $this->produits = $produits;
    }

    /**
     * @return mixed
     */
    public function getBoxs()
    {
        return $this->boxs;
    }

    /**
     * @param mixed $boxs
     */
    public function setBoxs($boxs): void
    {
        $this->boxs = $boxs;
    }


}
