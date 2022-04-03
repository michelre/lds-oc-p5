<?php

namespace Laura\P5\Controllers;

use Laura\P5\Models\ProductDAO;
use Laura\P5\Models\OrderDAO;

class BackendController {

    private $twig;
    private $productDAO;

    public function __construct($twig){
        $this->twig = $twig;
        $this->productDAO = new ProductDAO();
        $this->orderDAO = new OrderDAO();
    }

    public function home(){
        
        echo $this->twig->render('admin/index.html.twig', []);
        die();
    }

    public function listProducts(){
         
        $products = $this->productDAO->getAll(0, 1000);
        echo $this->twig->render('admin/list-articles.html.twig', ['products' => $products]);
        die();
    }

    public function listOrders(){
         
        $orders = $this->orderDAO->getAll(0, 1000);
        echo $this->twig->render('admin/list-orders.html.twig', ['orders' => $orders]);
        die();
    }

    public function addProduct(){
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
            $ext = explode('/', $image['type'])[1];
            $imageName = uniqid() . '.' . $ext;
            $res = move_uploaded_file($image['tmp_name'], __DIR__ . '/../../assets/images/' . $imageName);
            if(!$res){
                die("Erreur d'upload");
            }
        }
        $this->productDAO->create($product->title, $product->description, $imageName, $product->price);
        header('Location: /P5/admin');
        die();
    }

    public function updateProductForm($product, $files, $id) {
        $image = $files['image'];
        var_dump($product);
        $imageName = '';

        if(isset($image) && !empty($image['tmp_name'])){
            $ext = explode('/', $image['type'])[1];
            $imageName = uniqid() . '.' . $ext;
            $res = move_uploaded_file($image['tmp_name'], __DIR__ . '/../../assets/images/' . $imageName);
            if(!$res){
                die("Erreur d'upload");
            }
        }
        $this->productDAO->update($id, $product->title, $product->description, $imageName, $product->price);
        header('Location: /P5/admin');
        die();
    }


}