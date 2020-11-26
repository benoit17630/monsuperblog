<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route ("admin/categorie-list" ,name="admin-categorie-list")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function categoryList(CategoryRepository $categoryRepository)
    {

// j utilise la metode findall pour recuper toute les categories
        $categorys = $categoryRepository->findAll();

        return $this->render('admin/categories/admincategories.html.twig', [

            "categorys" => $categorys
        ]);
    }

    /**
     * @Route ("/categorie-show/{id}", name="categorie")
     * @param $id
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function categoryShow($id, CategoryRepository $categoryRepository){
// j utilise la metode find pour recuper chaque category une a une
        $cats= $categoryRepository->find($id);

        return $this->render('admin/categories/category.html.twig',[

            "cats"=>$cats
        ]);
    }



    /**
     * @Route ("admin/categorie-create", name="admin-categorie-create")
     * @param EntityManagerInterface $manager
     */
    public function insertCategory(Request $request, EntityManagerInterface $entityManager){

        $category = new Category();

        $formcategory = $this->createForm(CategoryType::class, $category);

        $formcategory->handleRequest($request);

        if ($formcategory->isSubmitted() && $formcategory->isValid()){

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                'sucess',
                "la categorie a ete ajouter"
            );

          return $this->redirectToRoute('admin-categorie-list');
        }

        $form =$formcategory->createView();

        return $this->render('admin/categories/insertcatgory.html.twig',[
            "form"=> $form
        ]);

    }

    /**
     * @Route ("/admin-update/{id}", name="admin-categorie-update")
     */
    public function updatecategorie($id,
                                    Request $request,
                                    CategoryRepository $categoryRepository,
                                    EntityManagerInterface $entityManager){
        $category = $categoryRepository->find($id);

        $formcategory = $this->createForm(CategoryType::class, $category);

        $formcategory->handleRequest($request);

        if ($formcategory->isSubmitted() && $formcategory->isValid()) {

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash(
                'sucess',
                "la categorie a ete modifier"
            );

            return $this->redirectToRoute('admin-categorie-list');
        }
            $form = $formcategory->createView();

            return $this->render("admin/categories/updatecategory.html.twig",[
                'form'=> $form
            ]);

    }

    /**
     * @Route ("/admin-categorie-delete/{id}", name="admin-categorie-delete")
     */
    public function deleteCategory($id,
                                   CategoryRepository $categoryRepository,
                                   EntityManagerInterface $entityManager){

        $category = $categoryRepository->find($id);

        if (!is_null($category)){

            $entityManager->remove($category);
            $entityManager->flush();

            $this->addFlash(
                'sucess',
                "la categorie a ete suprimer"
            );


        }
        return $this->redirectToRoute('admin-categorie-list');
    }



}