<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 11/12/2018
 * Time: 10:27
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Fournisseur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie",
     *     inversedBy="fournisseurs")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Vous devez choisir une catégoriew")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Saisissez le nom du fournisseur")
     * @Assert\Length(max="50",maxMessage="Le nom du fournisseur est tres long")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Saisissez l'adresse du fournisseur.html.twig")
     * @Assert\Length(max="50", maxMessage="L'adresse fournisseur est tres long, limites characters {{ limit }}")
     */
    private $adresse;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Membre",
     *     inversedBy="fournisseur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit",
     *     mappedBy="fournisseur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    public function __construct()
    {
        #$this->produits = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param mixed $membre
     */
    public function setMembre($membre): void
    {
        $this->membre = $membre;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }
}