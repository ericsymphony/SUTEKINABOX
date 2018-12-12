<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/12/2018
 * Time: 11:47
 */

namespace App\Produit;


use App\Entity\Box;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('prix', TextType::class,[
                'label' => 'Saisissez le prix produit',
                'attr' => [
                    'placeholder' => 'Saisissez le prix produit'
                ]
            ])

            # Champ Fournisseur
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])

            # Champ Box
            ->add('box', EntityType::class, [
                'class' => Box::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])

            # Champ Catégorie
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])

            ->add('submit', SubmitType::class,[
                'label' => 'Valider la création du produit !'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Produit::class,
            'image_url' => null
        ]);

    }


}