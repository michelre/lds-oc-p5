<?php

namespace Laura\P5\Controllers;

use Laura\P5\Models\ProductDAO;
use Laura\P5\Services\MailService;
use Laura\P5\Models\UserDAO;

class FrontendController {

    private $twig;
    private $productDAO;
    private $userDAO;

    public function __construct($twig){
        $this->twig = $twig;
        $this->productDAO = new ProductDAO();
        $this->userDAO = new UserDAO();
    }

    public function home(){
        $products = $this->productDAO->getAll(0, 3);
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
        $product = $this->productDAO->getOne($id);
        echo $this->twig->render('produit.html.twig', ['product' => $product]);
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

    public function login() {
        echo $this->twig->render('login.html.twig', []);
        die();
    }

    public function loginSubmit(){
        $user = $this->userDAO->getByLogin($_POST['login']);
        if(password_verify($_POST['password'], $user->password)){
            $_SESSION['user_id'] = $user->id;
            header('Location: /P5/admin');
            die();
        }
        header('Location: /P5/login');
        die();
    }


}