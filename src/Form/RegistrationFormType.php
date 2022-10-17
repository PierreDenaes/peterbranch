<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nom',
                'class' => 'w-full px-3 py-2 rounded-md border border-slate-400',
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Prénom',
                'class' => 'w-full px-3 py-2 rounded-md border border-slate-400',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => false,
                'choices' => [
                        'Particulier' => 'Particulier',
                        'Formateur' => 'Formateur',
                        'Entreprise' => 'Entreprise',
                        'Autre organisation' => 'Autre organisation',  
                ],
                'attr' => [
                'class' => 'w-full px-3 py-2 rounded-md border border-slate-400',
                ],
                'placeholder' => 'Je suis ...',
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Votre email',
                'class' => 'w-full px-3 py-2 rounded-md border border-slate-400',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'En vous inscrivant vous acceptez la politique de confidentialité ....',
                'mapped' => false,
                'attr' => ['class' => 'form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter la politique de confidentialité',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'options' => ['attr' => ['class' => 'w-full px-3 py-2 rounded-md border border-slate-400',
                'autocomplete' => 'new-password']],
                'required' => true,
                'first_options'  => ['attr' => ['placeholder' => 'Votre mot de passe','class' => 'w-full px-3 py-2 rounded-md border border-slate-400'],'label' => false],
                'second_options' => ['attr' => ['placeholder' => 'Confirmer votre mot de passe','class' => 'w-full px-3 py-2 rounded-md border border-slate-400'],'label' => false],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir plus de {{ limit }} caractère',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
