<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 05/12/2018
 * Time: 10:40
 */

namespace App\Box;


use App\Entity\Box;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            # Champ Nom
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => "Nom de la Box",
                'attr' => [
                    'placeholder' => "Nom de la Box"
                ]
            ])

            # Champ Produits
            ->add('produits', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'Produit',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])

            # Bouton Submit
            ->add('submit', SubmitType::class, [
                'label' => 'Créer cette Box'
            ]);



    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Box::class,
            'image_url' => null
        ]);

    }
}