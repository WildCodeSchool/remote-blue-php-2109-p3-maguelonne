<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleCategory;
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
                'category',
                EntityType::class,
                [
                    'label' => 'Catégorie',
                    'class' => ArticleCategory::class,
                ],
            )
            ->add(
                'summary',
                TextareaType::class,
                [
                    'label' => 'Résumé de l\'article',
                    'attr' => ['rows' => '5'],
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
                    'label' => 'Photo de l\'article (clic-droit: copier l\'adresse de l\'image)',
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
                    'label' => 'Temps de lecture (en minutes, ex: 10 pour 1Ominutes)',
                ],
            )
            ->add(
                'alt',
                TextType::class,
                [
                    'label' => 'Texte alternatif à l\'image',
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
