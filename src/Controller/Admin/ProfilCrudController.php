<?php

namespace App\Controller\Admin;

use App\Controller\VichImageField;
use App\Entity\Profil;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profil::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user');
        yield ImageField::new('imageName')->setBasePath('images/avatar')->onlyOnIndex();
        yield VichImageField::new('imageFile')->hideOnIndex();
        yield TextField::new('address');
        yield TextField::new('firstName');
        yield TextField::new('lastName');
        yield TextField::new('address');
        yield TextField::new('zipCode');
        yield TextField::new('country');
        yield TextField::new('status');
        yield TextField::new('siret');
        yield BooleanField::new('isActive');
    }
}
