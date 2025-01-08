<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Defile;
use App\Entity\Marque; 
use App\Entity\Mannequins;
use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Validator\Constraints\Date;
use \DateTime;

class DefileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomD', TextType::class, [
                'label' => "Nom du défilé",
                'attr' => [
                    'placeholder' => "Saisir le nom du défilé"
                ]
            ])
            ->add('mannequin', EntityType::class, [
                'class' => Mannequins::class, 
                'label' => 'nom', 
                'label' => 'Mannequins',
                'multiple' => true,
                'by_reference' => false, 
            ])
            ->add('Date', DateType::class, [
                'label' => 'Date du défilé',
                'format' => 'yyyy-MM-dd',
                'required' => true,
                'attr' => [
                    'max' => (new \DateTime())->format('Y-m-d'), 
                ],

            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class, 
                'label' => 'NomM', 
                'label' => 'Choisir une marque',
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['placeholder' => 'Courte biographie...', 'rows' => 10]
            ])
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'label' => 'nom', 
                'placeholder' => 'Choisir un thème',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Defile::class, 
        ]);
    }
}
