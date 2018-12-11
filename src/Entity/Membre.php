<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 * @UniqueEntity(fields={"email"},
 *  errorPath="email",
 *  message="Ce compte existe déjà !")
 */
class Membre implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Saisissez votre prenom")
     * @Assert\Length(max="50",maxMessage="Votre prenom est tres long")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Saisissez votre nom")
     * @Assert\Length(max="50", maxMessage="Votre nom est tres long, limites characters {{ limit }}")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Email(message="Verifiez votre email")
     * @Assert\NotBlank(message="Saisissez votre email")
     * @Assert\Length(max="80", maxMessage="tres long, limites characteres {{ limit }}")
     */
    private $email;



#* @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/",
#*     message="Votre mot de pass doit contenir 8 characteres ")
#* @Assert\Length(min="8",
#*     minMessage="dfsdfdsf",
#*     max="20",
#*     maxMessage="Votre mot de pass {{ limit }}")






    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Noubliez pas votre mot de pass")
     *
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $derniereConnexion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article",
     *     mappedBy="membre")
     */
    private $articles;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @Assert\IsTrue(message="...")
     */
    private $conditions;

    /**
     * @return mixed
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param mixed $conditions
     */
    public function setConditions($conditions): void
    {
        $this->conditions = $conditions;
    }

    /**
     * Membre constructor.
     */
    public function __construct(string $role = 'ROLE_MEMBRE')
    {
        $this->addRole($role);
        $this->articles = new ArrayCollection();
        $this->dateInscription = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->derniereConnexion;
    }

    public function setDerniereConnexion(string $timestamp = 'now') : self
    {
        $this->derniereConnexion = new \DateTime($timestamp);

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
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    public function addRole(string $role): bool
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }
}
