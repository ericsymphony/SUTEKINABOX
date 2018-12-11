<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/12/2018
 * Time: 11:47
 */

namespace App\Produit;


use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('reference', TextType::class,[
                'label' => 'Saisissez la référence produit',
                'attr' => [
                    'placeholder' => 'Saisissez la référence produit'
                ]
            ])
            ->add('nom', TextType::class,[
                'label' => 'Saisissez le nom du produit',
                'attr' => [
                    'placeholder' => 'Saisissez le nom du produit'
                ]
            ])
            ->add('prix', EmailType::class,[
                'label' => 'Saisissez le prix produit',
                'attr' => [
                    'placeholder' => 'Saisissez le prix produit'
                ]
            ])
            ->add('fournisseur', PasswordType::class,[
                'label' => 'Choisissez le fournisseur.html.twig du produit',
                'attr' => [
                    'placeholder' => 'Choisissez le fournisseur.html.twig du produit'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => "Valider la création du produit !"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Produit::class
        ]);

    }


}