<?php

namespace App\Controller\Admin;

use App\Entity\PostLike;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostLikeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PostLike::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
