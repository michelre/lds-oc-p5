<?php

require_once __DIR__ . '/vendor/autoload.php';

$klein = new \Klein\Klein();


$klein->with('/P5', function()  use ($klein){

    $klein->respond('GET', '/', function () {
        return "Page d'accueil";
    });
    
    $klein->respond('GET', '/products/[:id]', function ($request) {
        return 'Page produit ' . $request->id;
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