<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Model\FiltreBlog;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Defile;
use App\Repository\DefileRepository;

class FiltreBlogsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('defile', EntityType::class,[
                'class'=>Defile::class,
                'query_builder'=>function(DefileRepository $repo){
                        return $repo->listeDefileSimple();
                
                },
                'choice_label'=>'nomD',
                'label'=> "Nom du défilé",
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method'=>'get',
            'csrf_protection'=>false,
            'data_class'=> FiltreBlog::class
        ]);
    }
}
