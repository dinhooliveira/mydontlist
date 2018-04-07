<?php
  
  try
  {
    $host= "localhost";
    $dbname="mydontlist";
    $user="root";
    $pass="";
    $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
    
  }catch(Exception $e){

     $dados['successo']=false;
     $dados['mensagem'] = $e->getMessage();
     echo json_encode($dados);
     exit();
  }