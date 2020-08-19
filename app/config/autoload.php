<?php

spl_autoload_register(function($classname){
 
    $classname = lcfirst($classname);
    $classname = str_replace("\\", DIRECTORY_SEPARATOR, $classname);
    $classname .= ".php";
    require_once $classname;
});


function pageAccess(){
    @$open = fopen(LOG_FAJL, "a");
    if($open){
        $date = date('d-m-Y H:i:s');
        @fwrite($open,"{$_SERVER['REQUEST_URI']}\t{$date}\t{$_SERVER['REMOTE_ADDR']}\t\n");
        @fclose($open);
    }
}

function upisGresaka($greska){
    @$open=fopen(GRESKE_FAJL,"a");
    $unos=$greska."\t".date('d-m-Y H:i:s')."\n";
    @fwrite($open,$unos);
    @fclose($open);
  }

  function ispisTitle(){
    $url=explode("&",$_SERVER['REQUEST_URI']);
    $base="/php2g2t1/";
    switch ($url[0]){
    case "{$base}":
    echo "<title>Auros</title>";
    break;
    case "{$base}index.php":
    echo "<title>Auros</title>";
    break;
    case "{$base}index.php?page=home":
    echo "<title>Auros - Home</title>";
    break;
    case "{$base}index.php?page=home#products":
        echo "<title>Auros - Home</title>";
        break;
    case "{$base}index.php?page=about":
    echo "<title>Auros - About</title>";
    break;
    case "{$base}index.php?page=autor":
    echo "<title>Auros - Author</title>";
    break;
    case "{$base}index.php?page=bag":
    echo "<title>Auros - Cart</title>";
    break;
    case "{$base}index.php?page=contact":
    echo "<title>Auros - Contact</title>";
    break;
    case "{$base}index.php?page=admin":
    echo "<title>Auros - Admin</title>";
    break;
    case "{$base}index.php?page=orders":
    echo "<title>Auros - Admin Orders</title>";
    break; 
    case "{$base}index.php?page=logs":
    echo "<title>Auros - Admin Logs</title>";
    break;
    case "{$base}index.php?page=product":
    echo "<title>Auros - Product</title>";
    break;
  
    }
}
   