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
    define("BASE_URL", "https://smartguild.for7.com.br/");
    $_config['DBName'] = 'u401602409_smartprint';
    $_config['DBHost'] = 'localhost';
    $_config['DBUser'] = 'u401602409_smartprint';
    $_config['DBPass'] = '136655Sp31';
}

//informaçãoes do Paypal
$config['paypal_clientId'] = "AWSAHcMw1PWQCh6g4G80_VT2M9GGqUIiE_-6csz6Gx3tevgkcxZPh4kdtahtmGkn3lF1_nvu-aVcO63r";
$config['paypal_secret'] = "EMtNAjrdaP9Lhrlu4KH7cTd1mRqOEu487hjIq7znFwMya8ZUt_NAUiNwXYgK6ctGa_mAarG4i1F2Ilod";

try{
    $db = new PDO("mysql:dbname=".$_config['DBName'].";host=".$_config['DBHost'], $_config['DBUser'], $_config['DBPass']);
}catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}