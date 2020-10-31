<?php

namespace App\Form;

use App\Entity\ChargerConnection;
use App\Model\ReservationDTO;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime', DateTimeType::class)
            ->add('endTime', DateTimeType::class)
            ->add('chargerConnection', EntityType::class, [
                'class' => ChargerConnection::class,
                'choice_label' => 'id',
                'choice_value' => function (?ChargerConnection $entity) {
                    return $entity === null ? '' : $entity->getId();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationDTO::class
        ]);
    }
}
