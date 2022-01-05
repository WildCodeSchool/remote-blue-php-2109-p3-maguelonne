<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
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
                    'label' => 'Contenu de l\'article',
                    'attr' => ['rows' => '10'],
                ],
            )
            ->add(
                'poster',
                TextType::class,
                [
                    'label' => 'Photo de l\'article',
                ],
            )
            ->add(
                'createdAt',
                DateType::class,
                [
                    'label' => 'Date de création de l\'article',
                ],
            )
            ->add(
                'duration',
                NumberType::class,
                [
                    'label' => 'Durée de lecture',
                ],
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'label' => 'Texte Alternatif à l\'image',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
