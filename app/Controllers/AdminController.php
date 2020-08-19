<?php

namespace App\Controllers;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;

class AdminController extends Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function allProducts(){
            
        if(isset($_SESSION['user']) && $_SESSION['user']->idRole=="1"){
        $productModel=new Product($this->db);
        $allProd=$productModel->getAllProducts();
        $allCat=$productModel->getProductCat();
        $this->view("admin2",["products"=>$allProd,"cat"=>$allCat,"title"=>"Admin"]);
        }else{
            $this->redirect("index.php?page=404");
        }
        
    }

    public function getAllOrders(){
        $productModel=new Product($this->db);
        $userModel=new User($this->db);
        $cartModel=new Cart($this->db);
        $users=$userModel->getAllUsers();
        $products=$productModel->getAllProducts();
        $get=$cartModel->allOrders(); 
        $this->view("adminOrders",["orders"=>$get,"users"=>$users,"prod"=>$products,"title"=>"Admin Orders"]);
    }

    public function deleteOrder($id){
        if(isset($_POST['id'])){
            $adminModel=new Admin($this->db);
            try{
                $log=$adminModel->logAction($_SESSION['user']->fullName,"Delete Order");
                $deleteOrder=$adminModel->deleteOrderr($id);
                $this->json(["poruka"=>"Uspesno brisanje"],204);

                
            }catch(\PDOException $e){
                $this->json(["greska"=>"Bad request"],400);
                upisGresaka($e->getMessage());
            }
        
        }

    }

    public function addOrder(){
        if(isset($_POST['btnAddNewOrder'])){
            $name=$_POST['ddlUser'];
            $prod=$_POST['ddlProduct'];
            $error=[];

            if($name=="Select"){
                $error[]="select one user";
            }

            if($prod=="Select"){
                $error[]="select one product";
            }

            if(count($error)==0){
                $adminModel=new Admin($this->db); 
                try{
                    $result=$adminModel->addNewOrder($name,$prod);
                    $log=$adminModel->logAction($_SESSION['user']->fullName,"New Order");
                    $this->json(["poruka"=>"Uspesan unos"],201);
                }catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json([],500);
                }    
            }else{
                $this->json($error,422);
            }
        }else{
            $this->json([],400);
        }
          
        
    }

    public function getOrders(){
        $cartModel=new Cart($this->db);
        try{
            $get=$cartModel->allOrders(); 
            $this->json($get);
        }
        catch(\PDOException $e){
          upisGresaka($e->getMessage());
          $this->json([],500);
        } 
      
    }

    public function getActionLogs(){
        $adminModel=new Admin($this->db);
        try{
            $procenti=$adminModel->pageAccessPercentage();        
            $result=$adminModel->getActionLogs();
            $this->view("logs",["logs"=>$result,"proc"=>$procenti,"title"=>"Logs"]);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json([],500);
          }
        
    }

    public function insert(){
        if (isset($_POST['btnInsertNew'])){
            $name=$_POST['name'];
            $cat=$_POST['ddlCat'];
            $price=$_POST['price'];
            $des=$_POST['des'];
            $file=$_FILES['pic'];
            $fileName=$file['name'];
            $size=$file['size'];
            $type=$file['type'];
            $tmpPutannja=$file['tmp_name'];
            $error=[];
        
            $allowedFormat=array("image/jpg","image/jpeg","image/png","image/gif");
            if(!in_array($type,$allowedFormat)){
                $error[]="You can uploda just image";
            }
        
            if($size>3000000){
                $error[]="Image must be less then 3MB";
            }
            
            $newName=time().$fileName;
            $newPath="assets/images/".$newName;
        
            if(!$file['name']){
                $error[]="You must upload a photoo";
            }
        
        
            $reName="/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})*$/";
            $rePrice="/^[1-9][0-9]*$/";
        
            $error=[];
            if(!preg_match($reName,$name)){
                $error[]="Name of a product in incorretc format";
            }
            if(!preg_match($rePrice,$price)){
                $error[]="Price can't be cero or less";
            }
            if($cat=="Select"){
                $error[]="Please select one category";
            }
            $code=500;
            if(count($error)==0){
                $adminModel=new Admin($this->db); 
                try{
                    $uspeh = move_uploaded_file($tmpPutannja, $newPath);
                    $result=$adminModel->insertNewProduct($name,$cat,$price,$des,$newName);
                    $log=$adminModel->logAction($_SESSION['user']->fullName,"New Product");
                    $this->json(["poruka"=>"Uspesan unos"],201);
                }catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json([],500);
                }    
            }else{
                $this->json($error,422);
            }
        }else{
            $this->json([],400);
        }
       
    }

    public function delete($id){
        $adminModel=new Admin($this->db);
        try{
            $log=$adminModel->logAction($_SESSION['user']->fullName,"Delete Product");
            $adminModel->deleteProduct($id);
            $this->json(["poruka"=>"Uspesno brisanje"],204);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json([],500);
        }
        
    }

    public function update(){
        
        if (isset($_POST['btnUpdate']) && isset($_FILES['pic'])){
            $name=$_POST['name'];
            $cat=$_POST['ddlCat'];
            $des=$_POST['des'];
            $price=$_POST['price'];
            $idProd=$_POST['idProduct'];
            $file=$_FILES['pic'];
            $fileName=$file['name'];
            $size=$file['size'];
            $type=$file['type'];
            $tmpPutannja=$file['tmp_name'];
            $error=[];
        
            $allowedFormat=array("image/jpg","image/jpeg","image/png","image/gif");
            if(!in_array($type,$allowedFormat)){
                $error[]="You can uploda just image";
            }
        
            if($size>3000000){
                $error[]="Image must be less then 3MB";
            }
            
            $newName=time().$fileName;
            $newPath="assets/images/".$newName;
        
            if(!$file['name']){
                $error[]="You must upload a photoo";
            }
        
        
            $reName="/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})*$/";
            $rePrice="/^[1-9][0-9]*$/";
        
            $error=[];
            if(!preg_match($reName,$name)){
                $error[]="Name of a product in incorretc format";
            }
            if(!preg_match($rePrice,$price)){
                $error[]="Price can't be cero or less";
            }
            if($cat=="Select"){
                $error[]="Please select one category";
            }
            $code=500;
            if(count($error)==0){
                $adminModel=new Admin($this->db);
                
                try{
                    
                        $uspeh = move_uploaded_file($tmpPutannja, $newPath);
                        $update=$adminModel->updateProductWpic($name,$price,$cat,$des,$newName,$idProd);
                        $log=$adminModel->logAction($_SESSION['user']->fullName,"Edit Product");
                        $this->json(["poruka"=>"Uspesan unos"],201);
                    
                }catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json([],500);
                }    
            }else{
                $this->json($error,422);
            }
        }
        else if(isset($_POST['btnUpdate'])){
            $name=$_POST['name'];
            $cat=$_POST['ddlCat'];
            $des=$_POST['des'];
            $price=$_POST['price'];
            $idProd=$_POST['idProduct'];
            $error=[];
        
            $reName="/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{1,})*$/";
            $rePrice="/^[1-9][0-9]*$/";
        
            $error=[];
            if(!preg_match($reName,$name)){
                $error[]="Name of a product in incorretc format";
            }
            if(!preg_match($rePrice,$price)){
                $error[]="Price can't be cero or less";
            }
            if($cat=="Select"){
                $error[]="Please select one category";
            }
            $code=500;
            if(count($error)==0){
                $adminModel=new Admin($this->db);
                
                try{
                   
                        $update=$adminModel->updateProduct($name,$price,$cat,$des,$idProd);
                        $log=$adminModel->logAction($_SESSION['user']->fullName,"Edit Product");
                        $this->json(["poruka"=>"Uspesan unos"],201);
                   
                }catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json([],500);
                }    
            }else{
                $this->json($error,422);
            }
        }
        else{
            $this->json([],400);
        }
    }

    public function getP(){
        $productModel=new Product($this->db);
        try{
            $get=$productModel->getAllProducts(); 
            $this->json($get);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json([],500);
        }
        
    }


   
    
}