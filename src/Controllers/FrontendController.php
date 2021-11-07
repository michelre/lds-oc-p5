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


}