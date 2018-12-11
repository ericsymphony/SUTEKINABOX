<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/12/2018
 * Time: 14:10
 */

namespace App\Newsletter;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class NewsletterSubscriber implements EventSubscriberInterface
{
    /**
     * NewsletterSubscriber constructor.
     * @param SessionInterface $session
     */
    private function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest $event',
            KernelEvents::RESPONSE => 'onKernelResponse $event'

        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        # je m'assure que la requete vient de l'utilisateur et non de symfony
        if((!$event->isMasterRequest()) || $event->getRequest()->isXmlHttpRequest()){
            return;
        }

        # incrementation du nombre de page visitées par mon utilisateur
        $this->session->set('countVisitedPages',
            $this->session->get('countVisitedPages', 0)+1);

        #
        if($this->session->get('countVisitedPages')=== 3){
            $this->session->set('inviteUserModal', true);
        }

    }

    public function onKernelReponse(FilterResponseEvent $event)
    {
        # je m'assure que la requete vient de l'utilisateur et non de symfony
        if((!$event->isMasterRequest()) || $event->getRequest()->isXmlHttpRequest()){
            return;
        }

        # on repasse à false notre inviteUserModal
            $this->session->set('inviteUserModal', false);
        }

}