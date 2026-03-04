<?php

$servidor="localhost";
$baseDatos="livethefe";
$usuario="root";
$contraseña="";

try{

    $conexion=new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contraseña);
   

}catch(Exception $error){
    echo $error ->getMessage();
}

?>