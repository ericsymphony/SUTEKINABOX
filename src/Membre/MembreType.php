<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/12/2018
 * Time: 11:47
 */

namespace App\Membre;


use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('prenom', TextType::class,[
                'label' => 'Saisissez votre prénom',
                'attr' => [
                    'placeholder' => 'Saisissez votre prénom'
                ]
            ])
            ->add('nom', TextType::class,[
                'label' => 'Saisissez votre nom',
                'attr' => [
                    'placeholder' => 'Saisissez votre nom'
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Saisissez votre email',
                'attr' => [
                    'placeholder' => 'Saisissez votre email'
                ]
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Saisissez votre password',
                'attr' => [
                    'placeholder' => 'Saisissez votre password'
                ]
            ])
            ->add('conditions', CheckBoxType::class,[
                'label' => "J'accepte les CGU",
                'attr' => [
                    'data-toggle' => 'toggle',
                    'toggle-on' => 'oui',
                    'toggle-off' => 'non'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Je m'inscris !"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Membre::class
        ]);

    }


}