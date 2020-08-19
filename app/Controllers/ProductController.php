<?php

namespace App\Controllers;
use App\Models\Product;

class ProductController extends Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function sort(){
        if(isset($_POST['btnSort'])){
            $sortBy=$_POST['sortBy'];
            $catId=$_POST['catId'];
            $productModel=new Product($this->db);
            $someProducts=$productModel->sortProduct($sortBy,$catId);
            echo \json_encode($someProducts);
        }
    }

    public function showProdWithCat(){
        $id=$_POST['catId'];
        $productModel=new Product($this->db);
        try{
            if($id!=1){  
                $someProducts=$productModel->getProdWithCat($id);
           }else{
               $someProducts=$productModel->getAllProducts();
           }
           $this->json($someProducts);

        }
        catch(\PDOException $e){
            $this->json(["greska"=>"Bad request"],400);
            upisGresaka($e->getMessage());
        }
        
    }

    public function showOneProduct(){
        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $productModel=new Product($this->db);
            try{
                $one=$productModel->getOneProduct($id);
                $this->view("productDetails",["data"=>$one,"title"=>"Product Details"]);
            }catch(\PDOException $e){
                $this->json(["greska"=>"Bad request"],400);
                upisGresaka($e->getMessage());
            }
        }
    }

   
    
}