<?php

namespace App\Form;

use App\Entity\Records;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecordsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('artist', TextType::class)
            ->add('albumTitle', TextType::class)
            ->add('label', TextType::class)
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('vinylsNumber', TextType::class)
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Rock' => 'rock',
                    'Pop' => 'pop',
                    'Jazz' => 'jazz',
                    'Classical' => 'classical',
                    'Hip Hop' => 'hip-hop',
                ],
                'required' => true, 
            ])
            ->add('state', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Records::class,
            'csrf_protection' => false,
        ]);
    }
}
