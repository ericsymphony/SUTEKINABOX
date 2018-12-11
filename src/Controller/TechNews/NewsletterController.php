<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/12/2018
 * Time: 12:23
 */

namespace App\Controller\TechNews;


use App\Newsletter\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsletterController extends Controller
{

    /**
     * Afficher une Modal Newsletter
     */
    public function Newsletter()
    {
        $form = $this->createForm(NewsletterType::class);

        return $this->render('newsletter/_modal.html.twig',[
            'form' => $form->createView()
        ]);
    }
}