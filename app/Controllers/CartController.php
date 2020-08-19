<?php

namespace App\Controllers;
use App\Models\Cart;

class CartController extends Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addToCart($id){
        if(isset($_SESSION['user'])){
            $cartModel=new Cart($this->db);
            $user=$_SESSION['user']->idUser;
            try{
                $dodato=$cartModel->addProductToCart($id,$user);
                $this->json(["poruka"=>"Uspesno dodato"],201);
            }catch(\PDOException $e){
                $this->json(["greska"=>"Bad request"],400);
                upisGresaka($e->getMessage());
            }
        }else{
            $this->json(["poruka"=>"You must be logged in to add a product!"],409);
        }
       
        
    }

    public function getAllFromCard(){
        if(isset($_SESSION['user'])){
            $cartModel=new Cart($this->db);
            $user=$_SESSION['user']->idUser;
            try{
                $cardProducts=$cartModel->getProductCard($user);
                $this->json($cardProducts,200);
            }
            catch(\PDOException $e){
                $this->json(["greska"=>"Bad request"],400);
                upisGresaka($e->getMessage());
            }
        }
        else{
            $this->json(["poruka"=>"You must be logged in to add a product!"],409);
        }
        
        
    }

    public function showCard(){
        if(isset($_SESSION['user'])){
            $cartModel=new Cart($this->db);
            try{   
            $cardProducts=$cartModel->getProductCard($_SESSION['user']->idUser);
            $this->view("card",["products"=>$cardProducts,"title"=>"Cart"]);
            } 
            catch(\PDOException $e){
                $this->json(["greska"=>"Bad request"],400);
                upisGresaka($e->getMessage());
            }
        }
        else{
            $this->json(["poruka"=>"You must be logged in to see cart!"],409);
            $this->redirect("index.php?page=404");
        }
        
    }

    public function removeFromCard($id){
        if(isset($_SESSION['user'])){
            $cartModel=new Cart($this->db);
            try{   
                $cardProducts=$cartModel->remove($id);
                $this->json($cardProducts,204);
            } 
            catch(\PDOException $e){
                $this->json(["greska"=>"Bad request"],400);
                upisGresaka($e->getMessage());
            }
        } else{
            $this->json(["poruka"=>"You must be logged in to see cart!"],409);
            $this->redirect("index.php?page=404");
        }
        
    }

   
    
}