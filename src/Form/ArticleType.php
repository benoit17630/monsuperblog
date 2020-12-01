<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class ArticleType extends AbstractType


{
    // la ligne de commande bin/console make:form m'a permis de générer automatiquement ce fichier
    // c'est un gabarit de formulaire pour l'entité que j'ai spécifié en ligne de commande
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //pour traduire le title en titre je doit dir que le Type est null et je precise le label du nom de ma collone en fr
            ->add('title', null,[
                "label"=>'Titre'
            ])
            ->add('content',null,["label"=> 'Text'])
            ->add('image', FileType::class,[
                'mapped'=> false,
                'required'=> false,


            ])

            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text',
                'label'=> "Date de publication"

            ])
            ->add('creationDate',DateType::class,[
                'widget'=>'single_text',
                'label'=> "Date de creation"])
            ->add('isPublished',null,
                ["label"=>"publier ?"])
            ->add( "valider", SubmitType::class)
            //je cree le choix des category dans mon formulaire grace a EntityType::class
            ->add("category", EntityType::class,[
                //je dite dans quelle entity le choix est
                "class"=> Category::class,
                // je choisi la collone qui va etre afficher
                "choice_label"=>"title",
                //je renome en fr car mes utilisateur seront francais
                "label" => "Categorie"
                    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
