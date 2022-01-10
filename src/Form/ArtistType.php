<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'artiste"
            ])
            ->add('repository', TextType::class)
            ->add('photo', TextType::class, [
                'required' => false,
                'label' => 'photo',
            ])
            ->add('video', TextType::class, [
                'required' => false,
                'label' => 'lien vidéo',
                ])
            ->add('audio', TextType::class, [
                'required' => false,
                'label' => 'lien audio',
                ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité',
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Biographie de l\' artiste'
            ])
            ->add('instruments', EntityType::class, [
                'required' => false,
                ])
            ->add('slug', TextType::class, [
                'label' => 'slug',
            ])
            ->add('alt', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Créer un artiste',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
