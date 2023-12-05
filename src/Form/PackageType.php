<?php

namespace App\Form;

use App\Entity\Locker;
use App\Entity\Package;
use App\Entity\RelayCenter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weight')
            ->add('volume')
            ->add('relayCenter', EntityType::class, [
                'class' => RelayCenter::class,
                'choice_label' => 'city',
                'placeholder' => 'Select a relay center',
                'mapped' => false,
                'required' => false,
            ])
            ->add('locker', EntityType::class, [
                'class' => Locker::class,
                'choice_label' => 'locker_number',
                'placeholder' => 'Select a locker',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter un nouveau colis']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Package::class,
        ]);
    }
}
