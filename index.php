<?php

require_once __DIR__ . '/vendor/autoload.php';

use Laura\P5\Controllers\FrontendController;

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$frontendController = new FrontendController($twig);



$klein = new \Klein\Klein();


$klein->with('/P5', function()  use ($klein, $twig, $frontendController){

    $klein->respond('GET', '/', function () use($twig, $frontendController) {
        $frontendController->home();
    });
    
    $klein->respond('GET', '/products/[:id]', function ($request) use($twig) {
        echo $twig->render('produit.html.twig', ['id' => $request->id]);
    });

    $klein->respond('GET', '/cart', function ($request) {
        return 'Page panier';
    });

    $klein->respond('GET', '/confirmation', function ($request) {
        return '<h1>Confirmation</h1>';
    });

    $klein->respond('GET', '/contact', function ($request) {
        return 'Page contact';
    });

});

/*
 TODO
 - L'espace d'administration. Possibilité d'ajouter des nouveaux produits
 - Faire une URL publique pour charger les images 
 - Page products (avec pagnination)
 - Brancher la base de données
 - Page panier avec requête ajax pour envoi de la commande
 - Formulaire de contact avec envoi de mail (mailjet = service d'envoi de mail)
 - Créer un fichier de configuration pour la connexion DB
*/


$klein->dispatch();