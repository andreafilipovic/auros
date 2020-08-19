<?php
namespace App\Models;


class Admin {
    private $db;

    public function __construct(DB $db){
        $this->db = $db;
    }

    public function deleteOrderr($id){
        $query="DELETE FROM card WHERE idCart=?";
        $params=[$id];
        $statusCode=404;
        $data=null;
        try{
            $stmt=$this->db->executeWithParam($query,$params);
            if($stmt){
                $statusCode=204;
                
            }else{
                $statusCode=500; 
            }
        }
        catch(PDOException $e){
            $statusCode=500;
           
        };
        
        http_response_code($statusCode);
    }

    public function logAction($user,$action) {
        $param = [$user,$action];
        $query = "INSERT INTO actions (nameUser,nameAction) VALUES (?,?)";
        try{
            $dodaj=$this->db->executeWithParam($query,$param);
            if($dodaj){
                $code=201;
            }else{
                $code=500;
            }
        }catch(PDOException $e){
            $code=500;
        }
        http_response_code($code);
    }

    public function addNewOrder($name,$prod){
        $query="INSERT INTO card (idUser,idProduct) values(?,?)";
        $params=[$name,$prod];
        return $this->db->executeWithParam($query,$params);
    }

    function pageAccessPercentage(){
        $niz=[];
        $ukupno=0;
        $home=0;
        $author=0;
        $contact=0;
        $bag=0;
        $product=0;
        $about=0;
        $oneDayAgo=strtotime("1 day ago");
       
        $file=file(LOG_FAJL);
        if(count($file)){
       
        foreach($file as $i){
        $delovi=explode("\t",$i);
        $url=explode(".php",$delovi[0]);
        $strana=explode("&",$url[1]);
       
        if(strtotime($delovi[1])>=$oneDayAgo){
            switch($strana[0]){
                case "":$home++;$ukupno++;;break;
                case "?page=home":$home++;$ukupno++;;break;
                case "?page=autor":$author++;$ukupno++;;break;
                case "?page=contact":$contact++;$ukupno++;;break;
                case "?page=bag":$bag++;$ukupno++;;break;
                case "?page=product":$product++;$ukupno++;;break;
                case "?page=about":$about++;$ukupno++;;break;
                
                default:$home++;$ukupno++;;break;
            }
        }
    }
        if($ukupno>0){
            $niz[]=round($home*100/$ukupno,2);
            $niz[]=round($author*100/$ukupno,2);
            $niz[]=round($contact*100/$ukupno,2);
            $niz[]=round($bag*100/$ukupno,2);
            $niz[]=round($product*100/$ukupno,2);
            $niz[]=round($about*100/$ukupno,2);
      
            }
       
        }
        return $niz;
    }

    public function getActionLogs(){
        return $this->db->executeQuery("SELECT * FROM actions");
    }

    public function insertNewProduct($name,$cat,$price,$des,$newName) {
        
            $query="INSERT INTO product (nameProduct,idCat,price,description,picture) VALUES (?,?,?,?,?)";
            $params=[$name,$cat,$price,$des,$newName];
            return $this->db->executeWithParam($query,$params);

    }

    public function deleteProduct($id){
        $query="DELETE FROM product WHERE idProduct=?";
        $params=[$id];   
        return $this->db->executeWithParam($query,$params);
    }

    public function updateProduct($name,$price,$cat,$des,$idProd){
        $queryUpdate="UPDATE product SET nameProduct=?, price=?, idCat=?, description=? WHERE idProduct=?";
        $params=[$name,$price,$cat,$des,$idProd];
        return $this->db->executeWithParam($queryUpdate,$params);
     
                  
                  
    
    }
    
    public function updateProductWpic($name,$price,$cat,$des,$newName,$idProd){
      $queryUpdate="UPDATE product SET nameProduct=?, price=?, idCat=?, description=?, picture=? WHERE idProduct=?"; 
      $params=[$name,$price,$cat,$des,$newName,$idProd];
      return $this->db->executeWithParam($queryUpdate,$params);
    }


}