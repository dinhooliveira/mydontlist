<?php
 require_once('conexao.php');
 require_once('mydontlist.php');
 
 if(isset($_POST['item']) && $_POST['item']!='')
 {
     //teste de conexao
     $lista = new mylist();
     $lista->conexao = $pdo;
     $result = $lista->insert_myListDetail($_POST['item'],1,$_POST['id_lista']);
     
     echo json_encode($result);

 }else{
 
     $dados['success'] = false;
     $dados['message'] = "Não foi passado parametro POST ";
     $dados['data'] = array();
     echo json_encode($dados);
 }
 