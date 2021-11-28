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
        $product = $this->productDAO->getOne($productId);
        if(isset($product->image)){
            unlink(__DIR__ . '/../../' . $product->image);
        }
        $res = $this->productDAO->delete($productId);
        if($res){
            echo json_encode(['status' => 'OK']);
        } else {
            echo json_encode(['status' => 'KO']);
        }
        
        die();
    }

    public function addProductForm($product, $files) {
        $image = $files['image'];
        $imageName = '';
        if(isset($image)){
            $imageName = uniqid();
            $res = move_uploaded_file($image['tmp_name'], __DIR__ . '/../../assets/images/' . $imageName);
            if(!$res){
                die("Erreur d'upload");
            }
        }
        $this->productDAO->create($product->title, $product->description, 'assets/images/' . $imageName, $product->price);
        header('Location: /P5/admin');
        die();
    }


}