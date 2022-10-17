<?php

namespace App\Controller\Admin;

use App\Entity\PostComment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PostComment::class;
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
