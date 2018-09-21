<?php

namespace App\Form;

use App\Entity\Ground;
use App\Entity\Sport;
use App\Repository\SportRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GroundType extends AbstractType
{
    const GROUND_INDOOR     = "Interieur";
    const GROUND_OUTDOOR    = "Exterieur";

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, array('label' => 'Numéro du terrain', 'attr' => array('class' => 'form-control')))
            ->add('sport', EntityType::class,  array (
                'class'         => Sport::class,
                'query_builder' => function (SportRepository $repository)
                {
                    return $repository->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'attr'          => array('class' => 'form-control'),
            ))
            ->add('type', ChoiceType::class,  array (
                'choices' => array(
                    self::GROUND_INDOOR     => self::GROUND_INDOOR,
                    self::GROUND_OUTDOOR    => self::GROUND_OUTDOOR,
                ),
                'attr'          => array('class' => 'form-control'),
            ))

            ->add('submit', SubmitType::class, array('label' => 'Valider', 'attr' => array('class' => 'btn btn-primary' )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ground::class,
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