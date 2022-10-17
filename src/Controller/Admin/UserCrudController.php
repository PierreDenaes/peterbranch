<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $status = ["Particulier " , "Formateur", "Entreprise", "Autre organisation"];
        yield EmailField::new('email');
        yield TextField::new('password')->setFormType(PasswordType::class);
        yield ChoiceField::new('roles')
            ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges();
        yield TextField::new('name');
        yield TextField::new('firstName');
        yield ChoiceField::new('status')
            ->setChoices(array_combine($status, $status))
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges();
        yield BooleanField::new('isVerified');
    }
}
