<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AricleController extends AbstractController

{


    /**
     * @Route("/article-list", name="article-liste")
     * @param PaginatorInterface $pagination
     * @param Request $request
     * @param ArticleRepository $repository
     * @return Response
     */
    public function articleList(PaginatorInterface $pagination,
                                Request $request,
                                ArticleRepository $repository){

        $articles = $pagination->paginate(

           $repository->findAll(),
            $request->query->getInt('page',1),
            12

        );


        return $this->render("user/articles/articles.html.twig",[
            'articles'=>$articles
        ]);
    }
    /**
     * @Route ("/article_show/{id}", name="article")
     * @param $id
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function article($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);
        return$this->render('user/articles/article.html.twig',[
            "article"=>$article
        ]);
    }



    // pour injecter dans la bbd en dur



    // /**
    //  * @param EntityManagerInterface $manager
    //  * @Route ("/article-create", name="article-create")
    //  */
    /* public function articleCreateDur(EntityManagerInterface $manager){


        $article= new Article();
        $article ->setTitle('un nouveau article')
           ->setContent(" un super commentaire ")
            ->setImage('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRsBzm8Ep9fkjy73cDxSgoYOwrUlHXlHC8Bvw&usqp=CAU')
            ->setPublicationDate(new DateTime())
            ->setIsPublished(true)
            ->setCreationDate(new DateTime());
        $manager->persist($article);
        $manager->flush();
        die(dump('nouveau article ajouter'));
    }
//je creer une metode pour modifier le titre d un article
    /**
     * @Route ("/article-update/{id}", name="article-update")
     * @param $id
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $manager
     * @return Response
     * J'ai besoin de récupérer un article dans la table article donc je demande
     * à SF d'instancier pour moi l'ArticleRepository
     * J'ai aussi besoin de re-enregistrer cet article donc je demande à SF
     * d'instancier L'entityManagerInterface (EntityManager)
     */
    /* public function articleUpdateDur($id, ArticleRepository $articleRepository,EntityManagerInterface $manager){

         // je récupère l'article a modifier avec la méthode find du repository
         // La méthode find me renvoie une entité Article qui contient toutes les données
         // de l'article (titre, content etc)
         $article= $articleRepository->find($id);

         // Vu que j'ai récupéré une entité, je peux utiliser les setters
         // pour modifier les valeurs que je veux modifier
         $article->setTitle("mon super titre modifier");

         // une fois que j'ai modifié mon entité Article
         // je la re-enregistre avec l'entityManager et les méthodes
         // persist puis flush
         $manager->persist($article);
         $manager->flush();
        return $this->render("article/modif/article.html.twig");
     }*/
}