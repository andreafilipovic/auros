<?php

namespace App\Controllers;
use App\Models\User;

class UserController extends Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login(){
        if(isset($_POST["btnLogin"])){

            $email = $_POST["emailLogin"];
            $password = $_POST["passwordLogin"];
        
            $error=[];
            $rePass="/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
        
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($error,"incorrect format for email");
            } 
            else if(!$email){
                  array_push($error,"can not be empty");
            }
        
            if(!preg_match($rePass,$password)){
                array_push($error,"incorrect format for password");
            }
            else if(!$password){
                array_push($error,"can not be empty");
            }
        
            if(count($error)==0){
                $userModel=new User($this->db);
                try{
                    $stmt=$userModel->findeLogin($email,$password);
                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                }
                if($stmt) {
                    $_SESSION['user'] = $stmt;
                    if($_SESSION['user']->idRole=="1"){
                        $this->redirect("index.php?page=admin");
                    }else{
                        $this->redirect("index.php?page=home");
                    }

                
        
                } else {
                    
                $_SESSION["greska"] = "Incorrect username or passwordd.";
                $this->redirect("index.php");
                }
        
            }else {
                $_SESSION["greska"] = "Incorrect username or passwordd.";
                $this->redirect("index.php");
            
            }
    
     }
    }

    public function sendMail($request){
        if(isset($request['send'])){
            $mail=$request['mail'];
            $tekst=$request['tekst'];
            $ceotekst="Pošiljalac: {$mail}</br>{$tekst}";
            mail('anjamegi.af@gmail.com', "Obavestenje",$ceotekst);
            $this->json(["poruka"=>"Uspesno ste poslali poruku"]);
            }
            else{
            $this->json(["greska"=>"request"],400);
            }
        
    }

    public function singup(){
        $code=404;
        $data=null;
    
    if(isset($_POST['btnSignIn'])){
        $mail=$_POST['emailReg'];
        $name=$_POST['fullName'];
        $pass=$_POST['passwordReg'];
    
        $error=[];
        $reName="/^[A-Z][a-z]{2,}(\s[A-Z][a-z]{2,})+$/";
        $rePass="/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    
        if(!preg_match($reName,$name)){
            array_push($error,"incorrect format for name");
        }
        else if(!$name){
            array_push($error,'Can not be empty');
        }
    
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            array_push($error,"incorrect format for email");
        } 
        else if(!$mail){
              array_push($error,'Can not be empty');
        }
    
        if(!preg_match($rePass,$pass)){
            array_push($error,"incorrect format for password");
        }
        else if(!$pass){
            array_push($error,'Can not be empty');
        }
    
        
        if(count($error)==0){
            
            $userModel=new User($this->db);    
                try{
                    $reg=$userModel->registerNewUser($mail,$pass,$name);
                    if($reg){
                    $code=201;
                    $stmt=$userModel->findeLogin($mail,$pass);
                    $_SESSION['user'] = $stmt;
                    ob_start();
                    $this->redirect("index.php?page=home");
                    exit();
                    }else{
                        $code=500;
                    }; 
                }
                catch(PDOException $e){
                    $code=409;
                    upisGresaka($e->getMessage());

                }
    
            }
  
        else{
            $code=422;
           $data=$error;
        }   
    }
    
    http_response_code($code);
    echo json_encode($data);
    }

    public function logout(){
        $modelUser=new User($this->db);
        $modelUser->logoutUser();
        $this->redirect("index.php");
     }

   
    
}