<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 11/12/2018
 * Time: 10:27
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Saisissez le nom du fournisseur.html.twig")
     * @Assert\Length(max="50",maxMessage="Le nom du fournisseur.html.twig est tres long")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Saisissez l'adresse du fournisseur.html.twig")
     * @Assert\Length(max="50", maxMessage="L'adresse fournisseur.html.twig est tres long, limites characters {{ limit }}")
     */
    private $adresse;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Membre",
     *     inversedBy="fournisseur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    public function __construct()
    {

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



}