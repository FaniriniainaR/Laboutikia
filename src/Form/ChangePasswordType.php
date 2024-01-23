<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Votre nom',
            'disabled' => true
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Votre Prénom',
            'disabled' => true
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'disabled' => true
        ])
        ->add('old_mdp', PasswordType::class, [
            'label' => 'Votre mot de passe actuel',
            'mapped' => false
        ])
        ->add('new_mdp', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'Le mot de passe doit être identique!',
            'required' => true,
            'first_options' => ['label' => 'Votre nouveau Mot de passe'],
            'second_options' => ['label' => 'Confirmer votre nouveau mot de passe']
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Valider"
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
