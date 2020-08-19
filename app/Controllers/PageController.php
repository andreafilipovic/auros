<?php

namespace App\Controllers;
use App\Models\Product;
use App\Models\User;

class PageController extends Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function contact() {
        $this->view("contact",["title"=>"Contact"]);
    }
    
    public function about(){
        $this->view("about",["title"=>"About"]);
    }


    public function showProducts(){
        $productModel=new Product($this->db);
        try{
            $productCat=$productModel->getProductCat();
            $allProducts=$productModel->getAllProducts();
            $this->view("home",["categories"=>$productCat,"products"=>$allProducts,"title"=>"Home"]);
        }
        catch(\PDOException $e){
            $this->json(["greska"=>"Bad request"],400);
            upisGresaka($e->getMessage());
        }
        
    }

    public function getNav(){
        $userModel= new User($this->db);
        $meni=$userModel->getMeni();
        
        echo \json_encode($meni);
    }

    public function notFoundPage(){
        $this->view("404",["title"=>"Not found"]);
    }

    public function author(){
        $this->view("autor",["title"=>"Autor"]);
    }

    
}