<?php

require_once('conexao.php');
require_once('mydontlist.php');

if(isset($_POST['url']) )
{
    //teste de conexao
    $lista = new mylist();
    $lista->conexao = $pdo;
    $lista->url = $_POST['url'];
    $lista->dontlist();
}else{

    $dados['success'] = false;
    $dados['message'] = "Não foi passado parametro POST ";
    $dados['data'] = array();
    echo json_encode($dados);
}
