<?php

require_once __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);



$klein = new \Klein\Klein();


$klein->with('/P5', function()  use ($klein, $twig){

    $klein->respond('GET', '/', function () use($twig) {
        echo $twig->render('index.html.twig');
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


$klein->dispatch();