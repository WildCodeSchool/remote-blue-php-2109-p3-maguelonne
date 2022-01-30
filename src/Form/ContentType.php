<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                ],
            )
            ->add(
                'body',
                TextareaType::class,
                [
                    'label' => 'Contenu de la page',
                    'attr' => ['rows' => '20'],
                ],
            )
            ->add(
                'poster',
                TextType::class,
                [
                    'label' => 'Image d\'en-tête',
                ],
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'label' => 'Texte Alternatif à l\'image',
                ],
            )
            ->add('slug');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
