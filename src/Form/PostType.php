<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Votre titre',
                'attr' => ['placeholder' => 'Titre',
                    'class' => 'w-full px-3 py-2 rounded-md border border-slate-400'
                ],
            ])
            ->add('content', TextType::class, [
                'label' => 'Votre contenu',
                'attr' => ['placeholder' => 'Titre',
                    'class' => 'w-full px-3 py-2 rounded-md border border-slate-400'
                ],
            ])
            ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'image_uri' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
