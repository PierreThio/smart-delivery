<?php

namespace App\Form;

use App\Entity\RelayCenter;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefaultRelayCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('relayCenter', EntityType::class, ['class' => RelayCenter::class, 'choice_label' => function(RelayCenter $relayCenter){
                $label = $relayCenter->getCity()." ".$relayCenter->getAddress()." ".$relayCenter->getPostalCode();
                return $label;
            }])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
