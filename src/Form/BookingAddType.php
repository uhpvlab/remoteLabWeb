<?php

namespace App\Form;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookingDate', HiddenType::class)
            ->add('bookingTime', HiddenType::class)
            ->add('bookingTimeSlot', TimeType::class, ['input'  => 'timestamp',
                'widget' => 'single_text',])
            ->add('duration', ChoiceType::class, ['choices' => Booking::durationChoices])
            ->add('labSet',ChoiceType::class, ['choices' => Booking::labSets, 'multiple' => true])
            ->add('description')
            ->add('submit', SubmitType::class, ['label'=>'Add booking'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => Booking::class,
                    'fields' => ['bookingTime', 'duration'],
                    'repositoryMethod' => 'findConcurrency',
                    'message' => 'This date time is already in use. Select other or use the calendar view to avoid concurrency.',

                ]),
            ],
        ]);
    }
}
