<?php

namespace App\Form;

use App\Entity\Article;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType


{
    // la ligne de commande bin/console make:form m'a permis de générer automatiquement ce fichier
    // c'est un gabarit de formulaire pour l'entité que j'ai spécifié en ligne de commande
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('image')
            ->add('publicationDate' , DateType::class[
                'widget'  ])
            ->add('creationDate')
            ->add('isPublished')
            ->add( "valider", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
