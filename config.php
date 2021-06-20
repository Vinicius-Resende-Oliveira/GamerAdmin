<?php
require 'enviroment.php';

$_config = array();
global $db;
date_default_timezone_set('America/Sao_Paulo');
if(ENVIROMENT == "development"){
    define("BASE_URL", "http://localhost/portifolio/gameradmin/");
    $_config['DBName'] = 'gameradmin';
    $_config['DBHost'] = 'localhost';
    $_config['DBUser'] = 'root';
    $_config['DBPass'] = '';

}else{
    define("BASE_URL", "");
    $_config['DBName'] = '';
    $_config['DBHost'] = '';
    $_config['DBUser'] = '';
    $_config['DBPass'] = '';
}

//informaçãoes do Paypal
$config['paypal_clientId'] = "";
$config['paypal_secret'] = "";

try{
    $db = new PDO("mysql:dbname=".$_config['DBName'].";host=".$_config['DBHost'], $_config['DBUser'], $_config['DBPass']);
}catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}