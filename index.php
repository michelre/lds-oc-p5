<?php


require_once __DIR__ . '/vendor/autoload.php';
//define('APP_PATH', '/P5');

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

$klein->respond('GET', '/confirmation', function ($request) use($frontendController) {
    $frontendController->orderConfirmation($request);
});

$klein->respond('GET', '/login', function ($request) use($frontendController) {
    $frontendController->login();
});

$klein->respond('POST', '/login', function ($request) use($frontendController) {
    $frontendController->loginSubmit();
});

$klein->with('/admin', function()  use ($klein, $backendController) {


    $klein->respond('GET', '', function () use ($backendController) {
        AuthService::checkAuthentication();
        $backendController->home();
        die();
    });

    $klein->respond('GET', '/products', function () use ($backendController) {
        AuthService::checkAuthentication();
        $backendController->listProducts();
    });

    $klein->respond('GET', '/products/add', function () use ($backendController) {
        AuthService::checkAuthentication();
        $backendController->addProduct();
    });

    $klein->respond('POST', '/products', function ($request) use ($backendController) {
        AuthService::checkAuthentication();
        $backendController->addProductForm($request->paramsPost(), $request->files());
    });

    $klein->respond('POST', '/products/[:id]', function ($request) use ($backendController) {
        AuthService::checkAuthentication();
        $backendController->updateProductForm($request->paramsPost(), $request->files(), $request->id);
    });

    $klein->respond('GET', '/products/[:id]', function ($req) use($backendController) {
        AuthService::checkAuthentication();
        $backendController->updateProduct($req->id);
    });

    $klein->respond('GET', '/orders', function () use ($backendController) {
        AuthService::checkAuthentication();
        $backendController->listOrders();
    });

});

$klein->with('/api', function()  use ($klein, $twig, $backendController, $frontendController) {
    $klein->respond('DELETE', '/products/[:id]', function ($req) use($twig, $backendController) {
        $backendController->deleteProduct($req->id);
    });

    $klein->respond('POST', '/order', function ($req, $res) use($twig, $frontendController) {
        $frontendController->createOrder($req, $res);
    });
});

$klein->respond('/public/[*]', function($request, $response, $service, $app) {
    $filename = __DIR__ . '/' . $request->params()[1];
    $file = readfile($filename);
    $response->header('content-type',  \MimeType\MimeType::getType($filename));
    $response->body($file);
    $response->send();
});


$klein->dispatch();
