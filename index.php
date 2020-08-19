<?php
ob_start(); 
session_start();
require_once "app/config/autoload.php";
require_once "app/config/config.php";
//var_dump($_SESSION['user']);
use App\Models\DB;
use App\Controllers\PageController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\UserController;
use App\Controllers\AdminController;

$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);
$pageController = new PageController($db);
$productController=new ProductController($db);
$cartController=new CartController($db);
$userController=new UserController($db);
$adminController=new AdminController($db);


if(isset($_GET['page'])){
    switch($_GET['page']){
        case "home":
            $pageController->showProducts();
            break;
        case "about":
            $pageController->about();
            break;
        case "contact":
            $pageController->contact();
            break;
        case "sort": 
            $productController->sort();
            break;
        case "message":
            $userController->sendMail($_POST);
            break;
        case "kategorija": 
            $productController->showProdWithCat();
            break;
        case "product":
            if(isset($_GET['id'])){
                $productController->showOneProduct();
            }
            break;
        case "card":
                $cartController->addToCart($_POST['id']);
                break;
        case "getCard":
              $cartController->getAllFromCard();
                break;
        case "bag":
                $cartController->showCard();
                if(isset($_GET['id'])){
                  $cartController->removeFromCard($_GET['id']); 
                }
                break;
        case "nav":
              $pageController->getNav();
              break;
        case "login":
                $userController->login();
                break;
        case "register":
                $userController->singup();
                break;
        case "admin":
                $adminController->allProducts();
                break;
        case "orders":
                $adminController->getAllOrders();
                break;
        case "deleteOrder":
                $adminController->deleteOrder($_POST['id']);
                break;
        case "addOrder":
                $adminController->addOrder();
                break;
        case "getAllOrders":
                 $adminController->getOrders();
                 break;
        case "logs":
                  $adminController->getActionLogs();
                  break;
        case "insert":
                $adminController->insert();
                break;
        case "delete":
                $adminController->delete($_POST['id']);
                break;
        case "update":
                $adminController->update();
                break;
        case "getAll":
                $adminController->getP();
                break;
        case "logout":
                $userController->logout();
                break;
        case "404":
                $pageController->notFoundPage();
                break;
        case "autor":
                $pageController->author();
                break;
        
    }
} else {
    $pageController->showProducts();
}