<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/12/2018
 * Time: 10:40
 */

namespace App\Fournisseur;


use App\Entity\Categorie;
use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('nom', TextType::class,[
                'label' => 'Saisissez le nom du Fournisseur',
                'attr' => [
                    'placeholder' => 'Saisissez le nom du Fournisseur'
                ]
            ])
            ->add('adresse', TextType::class,[
                'label' => 'Saisissez l\'adresse du Fournisseur',
                'attr' => [
                    'placeholder' => 'Saisissez l\'adresse du Fournisseur'
                ]
            ])

            # Champ Catégorie
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])


            # Bouton Submit
            ->add('submit', SubmitType::class, [
                'label' => 'Valider ce Fournisseur'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
            'image_url' => null
        ]);

    }
}