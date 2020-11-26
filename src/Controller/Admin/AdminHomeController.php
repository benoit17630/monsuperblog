<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController

{

    /**
     * @Route("/admin" , name="admin-index")
     */
    public function adminHome(){

        return $this->render('admin/adminindex.html.twig');
    }
}