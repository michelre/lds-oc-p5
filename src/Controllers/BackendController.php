<?php

namespace Laura\P5\Controllers;

use Laura\P5\Models\ProductDAO;

class BackendController {

    private $twig;
    private $productDAO;

    public function __construct($twig){
        $this->twig = $twig;
        $this->productDAO = new ProductDAO();
    }

    public function home(){
        $products = $this->productDAO->getAll();
        echo $this->twig->render('admin/index.html.twig', ['products' => $products]);
        die();
    }

    public function addProduct(){
        $products = $this->productDAO->getAll();
        echo $this->twig->render('admin/add-product.html.twig', []);
        die();
    }

    public function updateProduct($productId){
        $product = $this->productDAO->getOne($productId);
        echo $this->twig->render('admin/update-product.html.twig', ['product' => $product]);
        die();
    }

    public function deleteProduct($productId){
        $res = $this->productDAO->delete($productId);
        if($res){
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['status' => 'KO']);
        }
        
        die();
    }


}