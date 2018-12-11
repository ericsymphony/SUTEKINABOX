<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 07/12/2018
 * Time: 12:14
 */

namespace App\Newsletter;


use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('email',EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Saisissez votre eMail"
                ]
            ])
            ->add("submit", SubmitType::class, [
                'label' => "Je m'inscris !"
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Newsletter::class);
    }


}