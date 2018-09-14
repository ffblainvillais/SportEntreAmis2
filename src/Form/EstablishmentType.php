<?php

namespace App\Form;

use App\Entity\Establishment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EstablishmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => "Nom de l'établissement", 'attr' => array('class' => 'form-control')))
            ->add('address', TextType::class, array('label' => 'Nom et numéro de rue', 'attr' => array('class' => 'form-control')))
            ->add('postalcode', IntegerType::class, array('label' => 'Code postal', 'attr' => array('class' => 'form-control')))
            ->add('city', TextType::class, array('label' => 'Ville', 'attr' => array('class' => 'form-control')))
            ->add('phone', IntegerType::class, array('label' => 'Téléphone', 'attr' => array('class' => 'form-control')))

            ->add('submit', SubmitType::class, array('label' => 'Valider', 'attr' => array('class' => 'btn btn-primary' )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Establishment::class,
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