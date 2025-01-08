<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('ancienPassword', PasswordType::class, [
            'label' => 'Ancien mot de passe',
            'attr' => ['autocomplete' => 'current-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer votre ancien mot de passe',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                    'max' => 4096,
                ]),
            ],
            'data' => $options['data']['plainPassword'] ?? '', // Définit une valeur par défaut
        ])
    ;
}


public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([]);
}
}
