<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email'
            ])            
            
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prenom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon Nom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'mdp actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder'=> 'merci de saisir le mdp actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'mdp et confirmation doivent etre identique',
                'label' => 'Votre Nouveau Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Nouveau Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre Nouveau MDP'
                    ]
                ],
                'second_options' => [
                    'label' => 'confirmez votre nouveau Mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer votre Nouveau MDP'
                    ]
                ],
                
            ]) 
            ->add('submit', SubmitType::class,[
                'label' => "Mettre a Jour"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
