<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/12/2018
 * Time: 17:10
 */

namespace App\Membre;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class MembreSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(ObjectManager $manager)
    {
        $this->em = $manager;
    }

public static function getSubscribedEvents()
{
    return  [
        SecurityEvents::INTERACTIVE_LOGIN=>'onSecurityInteractiveLogin'
    ];

}

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        # Récupération de l'utilisateur
        $membre = $event->getAuthenticationToken()->getUser();

        if($membre instanceof Membre)
        {
            $membre->setDerniereConnexion();
            $this->em->flush();
        }
    }
}