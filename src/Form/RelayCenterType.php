<?php

namespace App\Form;

use App\Entity\RelayCenter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelayCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('longitude')
            ->add('latitude')
            ->add('submit', SubmitType::class,[
            'label' => 'Ajouter un nouveau point relais'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RelayCenter::class,
        ]);
    }
}
