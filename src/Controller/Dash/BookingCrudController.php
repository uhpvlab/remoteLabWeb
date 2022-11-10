<?php

namespace App\Controller\Dash;

use App\Entity\Booking;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
//            AssociationField::new('user'),
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters); // TODO: Change the autogenerated stub
        dump($queryBuilder);
        return $queryBuilder->where('entity.user = :user')->setParameter('user', $this->getUser()->getId());
    }

}