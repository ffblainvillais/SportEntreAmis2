<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array('label' => 'Prenom', 'attr' => array('class' => 'form-control')))
            ->add('lastName', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
            ->add('email', EmailType::class, array('label' => 'Email', 'attr' => array('class' => 'form-control')))
            ->add('password', RepeatedType::class, array(
                'type'              => PasswordType::class,
                'first_options'     => array('label' => 'Mot de passe', 'attr' => array('class' => 'form-control')),
                'second_options'    => array('label' => 'Répéter le mot de passe', 'attr' => array('class' => 'form-control')),
            ))
            ->add('submit', SubmitType::class, array('label' => 'Inscription', 'attr' => array('class' => 'btn btn-primary' )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'task_item',
        ));
    }
}