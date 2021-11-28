<?php

namespace Laura\P5\Controllers;

use Laura\P5\Models\ProductDAO;

class FrontendController {

    private $twig;
    private $productDAO;

    public function __construct($twig){
        $this->twig = $twig;
        $this->productDAO = new ProductDAO();
    }

    public function home(){
        $products = $this->productDAO->getAll();
        echo $this->twig->render('index.html.twig', ['products' => $products]);
        die();
    }

    public function products() {
        $products = $this->productDAO->getAll();
        echo $this->twig->render('produits.html.twig', ['products' => $products]);
        die();
    }

    public function product($id){
        echo $this->twig->render('produit.html.twig', ['id' => $id]);
        die();
    }

    public function contact(){
        echo $this->twig->render('contact.html.twig', []);
        die();
    }

    public function cart(){
        echo $this->twig->render('cart.html.twig', []);
        die();
    }


}