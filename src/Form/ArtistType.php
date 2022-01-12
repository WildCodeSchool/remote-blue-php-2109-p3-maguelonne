<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('photo', TextType::class, [
                'required' => false,
                'label' => 'photo',
            ])
            ->add('name', TextType::class, [
                'label' => "Nom de l'artiste"
            ])
            ->add('instruments', TextType::class, [
                'required' => false,
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité',
            ])
            ->add('repository', TextType::class, [
                'label' => 'Répertoire musical'
            ])
            ->add('video', TextType::class, [
                'required' => false,
                'label' => 'lien vidéo',
            ])
            ->add('audio', TextType::class, [
                'required' => false,
                'label' => 'lien audio',
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Biographie de l\' artiste',
                'attr' => ['rows' => 10],
            ])
            ->add('slug', TextType::class, [
                'label' => 'slug',
            ])
            ->add('alt', TextType::class, [
                'label' => 'Texte alternatif de l\' image.'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
