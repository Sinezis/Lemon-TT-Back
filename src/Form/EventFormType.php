<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il est nécessaire que le titre de l\'événement ne soit pas vide.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Titre de l\'événement'
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il est nécessaire que la description de l\'événement ne soit pas vide.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('startDate', DateTimeType::class, [

            ])
            ->add('endDate', DateTimeType::class, [
                'attr' => [
                    'placeholder' => 'Date de fin'
                ]  
            ])
            ->add('location', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il est nécessaire que le lieu de l\'événement ne soit pas vide.'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Localisation'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}