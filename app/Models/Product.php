<?php

namespace App\Models;

class Product {
    private $db;

    public function __construct(DB $db){
        $this->db = $db;
    }

    public function getAll(){
        return $this->db->executeQuery("SELECT * FROM proizvod");
    }

    function getAllProducts(){
        return $this->db->executeQuery("SELECT p.*, c.nameCat FROM product p INNER JOIN category c on p.idCat=c.idCat");
    }

    function getProductCat(){
        return $this->db->executeQuery("SELECT * FROM category");
    }

    public function sortProduct($sortBy,$catId){
        try{
            if($sortBy=="Select"){
              return $this->db->executeQuery("SELECT * FROM product");
            }else{
               if($catId==1){
                  return $this->db->executeQuery("SELECT * FROM product order by price ".$sortBy);
               }else{
                      $query="SELECT * FROM product where idCat=? order by price ".$sortBy;
                      $params=[$catId];
                      return $this->db->executeQueryWithParams($query,$params);
                   }
              }
          }
          catch(PDOException $e){
              upisGresaka($e->getMessage());
          }
    }

    public function getProdWithCat($id){
        $query="SELECT * FROM product where idCat=?";
        $params=[$id];
        return $this->db->executeQueryWithParams($query,$params);
    }

    public function getOneProduct($id){
        $code=404;
        $data=null;
        try{
        $query="SELECT * FROM product p INNER JOIN category c ON p.idCat=c.idCat where idProduct=?";
        $params=[$id];
        $data=$this->db->executeQueryWithParams($query,$params);
        if($data){
            $code=200;

        }
        }catch(\PDOException $e ){
            $code=500;
            upisGresaka($e->getMessage());
        
        }
        http_response_code($code);
        return $data;
    }

}