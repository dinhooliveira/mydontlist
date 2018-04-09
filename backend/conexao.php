<?php
  
  try
  {
    $host= "localhost";
    $dbname="mydontlist";
    $user="root";
    $pass="";
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  }catch(Exception $e){

     $dados['successo']=false;
     $dados['mensagem'] = $e->getMessage();
     echo json_encode($dados);
     exit();
  }