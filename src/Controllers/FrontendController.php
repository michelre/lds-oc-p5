<?php

namespace Laura\P5\Controllers;

use Laura\P5\Models\ProductDAO;
use Laura\P5\Services\MailService;

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
        $limit = 10;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;
        $products = $this->productDAO->getAll($offset, $limit);
        $totalProducts = $this->productDAO->getTotal();
        $nbPages = ceil($totalProducts / $limit);
        echo $this->twig->render('produits.html.twig', ['products' => $products, 'page' => $page, 'nbPages' => $nbPages]);
        die();
    }

    public function product($id){
        echo $this->twig->render('produit.html.twig', ['id' => $id]);
        die();
    }

    public function contact(){
        new MailService();
        echo $this->twig->render('contact.html.twig', []);
        die();
    }

    public function cart(){
        echo $this->twig->render('cart.html.twig', []);
        die();
    }

    public function contactSubmit() {
        $mailService = new MailService();
        $body = "<h1>Nouveau contact</h1>
        <ul>
            <li>Nom: " . $_POST['name'] . "</li>
            <li>Email: " . $_POST['email'] . "</li>
            <li>Demande: " . $_POST['description'] . "</li>
        </ul>";
        $mailService->sendMail('Nouveau contact', $body);
        header('Location: /P5/contact');
        die();

    }


}