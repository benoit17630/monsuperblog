<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text'

            ])
            ->add('creationDate',DateType::class,[
                'widget'=>'single_text'])
            ->add('isPublished')
            ->add( "valider", SubmitType::class)
            ->add("category", EntityType::class,[
                "class"=> Category::class,
                    "choice_label"=>"title"]
                )


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
