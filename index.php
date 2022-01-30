<?php

require_once __DIR__ . '/vendor/autoload.php';

use Laura\P5\Controllers\FrontendController;
use Laura\P5\Controllers\BackendController;
use Laura\P5\Services\AuthService;

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/Views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$frontendController = new FrontendController($twig);
$backendController = new BackendController($twig);



$klein = new \Klein\Klein();


$klein->with('/P5', function()  use ($klein, $twig, $frontendController, $backendController){
    session_start();

    $klein->respond('GET', '/', function () use($twig, $frontendController) {
        $frontendController->home();
    });

    $klein->respond('GET', '/products', function ($request) use($twig, $frontendController) {
        $frontendController->products();
    });
    
    $klein->respond('GET', '/products/[:id]', function ($request) use($frontendController) {
        $frontendController->product($request->id);
    });

    $klein->respond('GET', '/contact', function ($request) use($frontendController) {
        $frontendController->contact();
    });

    $klein->respond('POST', '/contact', function ($request) use($frontendController) {
        $frontendController->contactSubmit();
    });

    $klein->respond('GET', '/cart', function ($request) use($frontendController) {
        $frontendController->cart();
    });

    $klein->respond('GET', '/login', function ($request) use($frontendController) {
        $frontendController->login();
    });

    $klein->respond('POST', '/login', function ($request) use($frontendController) {
        $frontendController->loginSubmit();
    });

    $klein->respond('GET', '/confirmation', function ($request) {
        return '<h1>Confirmation</h1>';
    });

    $klein->with('/admin', function()  use ($klein, $backendController) {

    
        $klein->respond('GET', '', function () use ($backendController) {
            AuthService::checkAuthentication();
            $backendController->home();
            die();
        });

        $klein->respond('GET', '/products', function () use ($backendController) {
            AuthService::checkAuthentication();
            $backendController->addProduct();
        });

        $klein->respond('POST', '/products', function ($request) use ($backendController) {
            AuthService::checkAuthentication();
            $backendController->addProductForm($request->paramsPost(), $request->files());
        });

        $klein->respond('GET', '/products/[:id]', function ($req) use($backendController) {
            AuthService::checkAuthentication();
            $backendController->updateProduct($req->id);
        });
    });

    $klein->with('/api', function()  use ($klein, $twig, $backendController) {
        $klein->respond('DELETE', '/products/[:id]', function ($req) use($twig, $backendController) {
            $backendController->deleteProduct($req->id);
        });
    });

    $klein->respond('/public/[*]', function($request, $response, $service, $app) {
        return $response->file(__DIR__ . $request->pathname());
    });

});

/*
 TODO
 - Possibilité de modifier des articles
 - Page panier avec requête ajax pour envoi de la commande
 - Mettre en place une authentification pour accéder à l'admin
*/


$klein->dispatch();