<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            EmailField::new('email'),
            TextField::new('name'),
            TextField::new('institution'),
            ChoiceField::new('roles')->setChoices([
                'Administrador' => 'ROLE_ADMIN',
                'Usuario' => 'ROLE_USER',
            ])->allowMultipleChoices()
            ,
            BooleanField::new('isVerified'),
            BooleanField::new('isAdmin')->renderAsSwitch(false)->hideOnForm(),
            DateTimeField::new('lastLogin')->hideOnForm()

        ];
    }

}
