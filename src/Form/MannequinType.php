<?php

namespace App\Form;
use App\Entity\Defile;
use App\Entity\Mannequins;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MannequinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageFile', FileType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'chargez la pochette',
            'attr'=>[
                'accept'=>".jpng,.png"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ]

            
        ])  
            ->add('imageMannequins', HiddenType::class)
            ->add('Nom', TextType::class, [
                  'label'=>"Nom du mannequin",
                  'required'=>false,
                  'attr'=>[
                        'placeholder'=>"Saisir le nom du mannequin"
                  ]
                ])
            ->add('Prenom', TextType::class, [
                // 'constraints' => [
                //     new NotBlank(['message' => 'Le prénom est obligatoire.']),
                //     new Length(['min' => 2, 'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères.']),
                // ],
            ])
            ->add('Nationalite', TextType::class, [
                'constraints' => [
                    // new NotBlank(['message' => 'La nationalité est obligatoire.']),
                ],
            ])
            ->add('biographieM', TextareaType::class, [
                'attr' => ['placeholder' => 'Courte biographie...', 'rows' => 10],
                // 'constraints' => [
                //     new NotBlank(['message' => 'La biographie est obligatoire.']),
                //     new Length(['min' => 20, 'minMessage' => 'La biographie doit comporter au moins {{ limit }} caractères.']),
                // ],
            ]) 
            ->add('defiles', EntityType::class, [
                'class' => Defile::class, 
                'label' => 'nom', 
                'label' => 'defiles',
                'multiple' => true,
                'by_reference' => false, 
            ]);


        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mannequins::class,
        ]);
    }
}
