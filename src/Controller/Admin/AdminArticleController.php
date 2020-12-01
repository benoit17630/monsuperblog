<?php


namespace App\Controller\Admin;


use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class AdminArticleController extends  AbstractController
{

    

    /**
     * @Route("admin/article-list", name="admin-article-liste")
     * @param ArticleRepository $repository
     * @param PaginatorInterface $pagination
     * @param Request $request
     * @return Response
     */
    public function articleList(ArticleRepository $repository,
                                PaginatorInterface $pagination,
                                Request $request){


        $articles = $pagination->paginate(

          $repository->findAll(),
              $request->query->getInt('page',1),
            12

        );

        return $this->render("admin/article/adminarticles.html.twig",[
            'articles'=>$articles
        ]);
    }

    /**
     * @Route ("admin/article-insert", name="admin-article-insert")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {

        // Je créé une nouvelle instance de l'entité Article
        // pour créer un nouveau enregistrement en bdd
        $article = new Article();


        // je veux afficher un formulaire pour créer des articles
        // donc je viens récupérer le gabarit de formulaire ArticleType créé en ligne de commandes
        // en utilisant la méthode createForm de l'AbstractController (et je lui passe en parametre
        // le gabarit de formulaire à créer)

        $form = $this->createForm(ArticleType::class, $article);

        // Je viens lier le formulaire créé
        // à la requête POST
        // de cette manière, je pourrai utiliser la variable $form
        // pour vérifier si les données POST ont été envoyées ou pas
        $form->handleRequest($request);

        // si le formulaire a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            $imagefile = $form->get('image')->getData();

            if ($imagefile){

                $originalFilename = pathinfo($imagefile->getClientOriginalName(),PATHINFO_FILENAME);

                $safeFilename= $slugger->slug($originalFilename);

                $newFilename = $safeFilename.'_'.uniqid().'.'.$imagefile->guessextension();

                try {
                    $imagefile->move(

                        $this->getParameter('images_directory'),

                        $newFilename

                    );

                }catch (FileException $exception){

                }

                $article->setImage($newFilename);

            }




            //alor je peut faire mon enregistrement
            $entityManager->persist($article);

            $entityManager->flush();

            $this->addFlash(

                'sucess',

                "l article a ete créer"

            );

            //je retourne sur la page qui affiche tous les articles
            return $this->redirectToRoute('admin-index');
        }

        // je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire avec
        // ce qui me permet de pouvoir afficher le formulaire html dans twig
        $formarticle = $form->createView();

        // j'envoie la vue de mon formulaire à twig

        return $this->render("admin/article/insert.html.twig", [
            'formarticle' => $formarticle
        ]);
    }

    /**
     * @Route ("admin/article-update/{id}", name="admin-article-update")
     * @param $id
     * @param Request $request
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateArticle($id,
                                  Request $request,
                                  ArticleRepository $articleRepository,
                                  EntityManagerInterface $entityManager)
    {


        $article=  $articleRepository->find($id);



        $form = $this->createForm(ArticleType::class, $article);


        $form->handleRequest($request);

        // si le formulaire a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()){

            //alor je peut faire mon enregistrement
            $entityManager->persist($article);
            $entityManager->flush();


            //si l article a ete modifier
            //j ajoute un message flash de type sucess
            $this->addFlash(
                'sucess',
                "l article a ete modifier"
            );

            //je retourne sur la page qui affiche tous les articles
            return $this->redirectToRoute('admin-article-liste');
        }

        // je prends le gabarit de formulaire récupéré et je créé une "vue" de formulaire avec
        // ce qui me permet de pouvoir afficher le formulaire html dans twig
        $formarticle= $form->createView();

        // j'envoie la vue de mon formulaire à twig

        return $this->render("admin/article/update.html.twig",[
            'formarticle'=>$formarticle
        ]);
    }

    /**
     * @Route ("admin/article-delete/{id}", name="admin-article-delete")
     *  je récupère la wildcard de l'url dans le parametre $id
     * je demande à SF d'instancier les classes ArticleRepository et
     * EntityManager (autowire)
     * @param $id
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function articleDelete($id,ArticleRepository $articleRepository,EntityManagerInterface $manager){

        // je récupère en bdd l'article dont l'id correspond à celui passé en url (wildcard)
        $article= $articleRepository->find($id);

        // si cet article existe en bdd (donc que la valeur d'$article n'est pas "null"
        // alors je le supprime avec la méthode remove de l'entityManager
        if (!is_null($article)){

            $manager->remove($article);
            $manager->flush();

            //si l article a ete suprimer
            //j ajoute un message flash de type sucess

            $this->addFlash(
                'sucess',
                "l article a ete suprimer"
            );

        }
        //je retourne sur la page qui affiche tous les articles
        return $this->redirectToRoute('admin-article-liste');
    }



}