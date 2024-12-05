<?php

namespace App\Form;


use App\Form\DefileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>"Nom du defile",
                'attr'=>[
                    "placeholder"=>"Saisir le nom du defile"
                ]
            ])
            ->add('description', TextareaType::class)
            ->add('site',UrlType::class)
            ->add('image', TextType::class)
            ->add('type',ChoiceType::class, [
                "choices"=>[
                    "solo"=>0,
                    "groupe"=>1
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
