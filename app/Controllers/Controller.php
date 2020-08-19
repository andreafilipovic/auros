<?php

namespace App\Controllers;

class Controller {

    protected function view($fileName, $data = []){
        
        extract($data); 
        include "app/views/fixed/head.php";
        include "app/views/fixed/nav.php";
        if($title=="Home"){
        include "app/views/fixed/slider.php";
        }
        include "app/views/pages/$fileName.php";
        include "app/views/fixed/footer.php";
    }

    protected function redirect($page) {
        header("Location: " . $page);
    }

    protected function json($data = null, $statusCode =200) {
     header("content-type: application/json");
     http_response_code($statusCode);
     echo json_encode($data);
     }
}