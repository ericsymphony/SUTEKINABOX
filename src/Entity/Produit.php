<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
     *     inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Vous devez choisir une catégoriew")
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir une référence.")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Votre référence ne doit pas dépasser {{ limit }} caractères  "
     * )
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="Vous devez saisir le nom du produit.")
     * @Assert\Length(
     *     max="50",
     *     maxMessage="Votre nom ne doit pas dépasser {{ limit }} caractères  "
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez saisir un prix.")
     * @Assert\Length(
     *     max="10000",
     *     maxMessage="Votre prix produit doit être un entier inférieur à {{ limit }} "
     * )
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur",
     *     inversedBy="produits")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotNull(message="Vous devez choisir un fournisseur")
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Box",
     *     inversedBy="produits")
     * @ORM\JoinColumn(nullable=true)
     */
    private $box;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Membre",
     *     inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    public function __construct()
    {
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
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
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
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
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

    /**
     * @return mixed
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param mixed $fournisseur
     */
    public function setFournisseur($fournisseur): void
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * @return mixed
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * @param mixed $box
     */
    public function setBox($box): void
    {
        $this->box = $box;
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


}
