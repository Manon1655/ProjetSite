<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Model\FiltreMannequin;

class FiltreMannequinsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class,[
                'attr'=>[
                    'placeholder'=>"Saisir une partie du nom du mannequin recherché"
                ],
                'required'=>false,
                'label'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method'=>'get',
            'csrf_protection'=>false,
            'data_class'=> FiltreMannequin::class
        ]);
    }
}
