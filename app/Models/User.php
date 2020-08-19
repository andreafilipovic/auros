<?php
namespace App\Models;

class User {
    private $db;

    public function __construct(DB $db){
        $this->db = $db;
    }

    function findeLogin($email,$password){
        $md5Pass=md5($password);
        $query="SELECT u.* FROM user u inner join role r on u.idRole=r.idRole where u.email=? and u.password=?";
        $params=[$email,$md5Pass];
        return $this->db->returnOneRowWithParams($query,$params);
    }

    public function getAllUsers(){
        $query="SELECT * from user";
        return $this->db->executeQuery($query);
    }

    function registerNewUser($mail,$pass,$fullName){
        //global $conn;
        $md5Passwd=md5($pass);
        $query="INSERT INTO user (fullName,email,password) VALUES (?,?,?)";
        $parameters=[$fullName,$mail,$md5Passwd]; 
        return $this->db->executeWithParam($query,$parameters);

    }

    function getMeni(){
        if(isset($_SESSION['user'])){
            if($_SESSION['user']->idRole == '2'){
                $query="SELECT * FROM meni where permission in (0,1) AND title not like 'Auros'";
               return $this->db->executeQuery($query);
            }
            else {
                $query="SELECT * FROM meni where permission in (0,1,2) AND title not like 'Auros'";
                return  $this->db->executeQuery($query); 
            }
        }
        else{
            $query="SELECT * FROM meni where permission=0 AND title not like 'Auros'";
            return  $this->db->executeQuery($query);
        }
    }

    function logoutUser(){
        
        unset($_SESSION["user"]);

    }

    public function sendiMail($request){
     
    }
       

    

}









   