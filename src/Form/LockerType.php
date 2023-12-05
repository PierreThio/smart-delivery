<?php

namespace App\Form;

use App\Entity\Locker;
use App\Entity\RelayCenter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LockerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $relayCenter = $options['relayCenter'] ?? null;

        $builder
            ->add('locker', EntityType::class, [
                'class' => Locker::class,
                'choice_label' => 'locker_number',
                'placeholder' => 'Select a locker',
                'choices' => $relayCenter ? $relayCenter->getLockers() : [],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Locker::class,
        ]);
    }
}
