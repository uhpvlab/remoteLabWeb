<?php

namespace App\Controller\Admin;

use App\Entity\Bookings;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class BookingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bookings::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            AssociationField::new('user'),
            DateTimeField::new('bookingTime'),

            ChoiceField::new('duration')
                ->setChoices([
                    '2h' => 120,
                    '1h' => 60,
                    '45m' => 45,
                    '30m' => 30,
                    '15m' => 15,
                    '10m' => 10,
                ])
                ->setRequired(true),

            ChoiceField::new('visibility')
                ->setChoices([
                    'public' => 'public',
                    'private' => 'private',
                    'shared' => 'shared',
                ])
                ->setRequired(true)
        ];
    }

}
