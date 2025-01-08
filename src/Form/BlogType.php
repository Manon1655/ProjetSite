<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Defile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomArticle', TextType::class, [
                'label' => 'Nom de l\'article',
            ])
            ->add('Contenu', TextareaType::class, [
                'label' => 'Contenu de l\'article',
            ])
            ->add('Date', DateType::class, [
                'label' => 'Date du défilé',
                'format' => 'yyyy-MM-dd',
                'required' => true,
                'attr' => [
                    'max' => (new \DateTime())->format('Y-m-d'), 
                ],
               
            ])
            ->add('defile', EntityType::class, [
                'class' => Defile::class,
                'choice_label' => 'NomD',  
                'label' => 'Défilé associé',
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false, 
                'attr' => ['accept' => 'image/*']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}

