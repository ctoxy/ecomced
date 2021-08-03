<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Votre Prenom',
                //ajout d'un validator en exemple
                'constraints' => new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prenom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Votre Nom',
                //ajout d'un validator en exemple
                'constraints' => new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre Nom'
                ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'Votre Email',
                //ajout d'un validator en exemple
                'constraints' => new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre email'
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'mdp et confirmation doivent etre identique',
                'label' => 'Votre Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre MDP'
                    ]
                ],
                'second_options' => [
                    'label' => 'confirmez votre Mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer votre MDP'
                    ]
                ],
                
            ])        
            ->add('submit', SubmitType::class,[
                'label' => "S'incrire"
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
