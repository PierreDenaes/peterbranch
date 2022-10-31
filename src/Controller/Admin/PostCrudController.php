<?php

namespace App\Controller\Admin;

use App\Controller\VichImageField;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('idProfil');
        yield TextField::new('title');
        yield TextEditorField::new('content');
        yield ImageField::new('imageName')->setBasePath('images/post')->onlyOnIndex();
        yield VichImageField::new('imageFile')->hideOnIndex();
        yield DateTimeField::new('createdAt');
        yield BooleanField::new('isActive');

    }

}
