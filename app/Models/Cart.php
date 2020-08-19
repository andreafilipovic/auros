<?php

namespace App\Models;

class Cart {
    private $db;

    public function __construct(DB $db){
        $this->db = $db;
    }

    public function addProductToCart($id,$user){
       
            $query="INSERT INTO card (idUser,idProduct) VALUES (?,?)";
            $parameters=[$user,$id]; 
            return $this->db->executeWithParam($query,$parameters);
    }

    public function getProductCard($user){
        
            $query="SELECT c.*, p.*from card c inner join product p on c.idProduct=p.idProduct where idUser=?";
            $params=[$user];
            return $this->db->executeQueryWithParams($query,$params);

    }

    public function prebroj($user){
        $query="SELECT COUNT(idCart) as 'broj' from card c inner join product p on c.idProduct=p.idProduct where idUser=?";
        $params=[$user];
        return $this->db->returnOneRowWithParams($query,$params);
    }

    public function remove($id){
        
            $query="DELETE FROM card where idCart=?";
            $params=[$id];
            return $this->db->executeWithParam($query,$params);
      
    }

    public function allOrders(){
        $query="SELECT * from card c INNER JOIN user u on c.idUser=u.idUser INNER join product p on p.idProduct=c.idProduct order by c.date";
        return $this->db->executeQuery($query);
    }
}