<?php

namespace App\Service\Twig;


use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

    private $em;
    private $session;
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $manager
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $manager, SessionInterface $session)
    {
        $this->em = $manager;
        $this->session=$session;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('getCategories', function() {
                return $this->em->getRepository(Categorie::class)
                    ->findCategoriesHavingArticles();
            }),
            new \Twig_Function('isUserInvited', function() {
                return $this->session->get('inviteUserModal');
            })
        ];
    }

    public function getFilters(){
        return [
            new \Twig_Filter('summary', function ($text) {
                // Suppression des Balises HTML
                $string = strip_tags($text);
                // si mon string >170 je continue
                if (strlen($string) > self::NB_SUMMARY_CHAR) {
                    // je coup me chaine à 170
                    $stringCut = substr($string, 0, self::NB_SUMMARY_CHAR);
                    $string = substr($stringCut, 0, strripos($stringCut, ' ')) . '...';
                }
                return $string;
            }, ['is_safe'=> ['html']])
        ];

    }

}