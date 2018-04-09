<?php

require_once('conexao.php');
require_once('mydontlist.php');

if(isset($_POST['id_item']) )
{
    //teste de conexao
    $lista = new mylist();
    $lista->conexao = $pdo;

    if( isset($_POST['status']) && !isset($_POST['text']) )
    {
        $lista->update_item($_POST['id_item'], $_POST['status'] ,false );
    }
      

    if( !isset($_POST['status']) && isset($_POST['text'])  )
        $lista->update_item($_POST['id_item'],false, $_POST['text'] );

}else{

    $dados['success'] = false;
    $dados['message'] = "Não foi passado parametro POST ";
    $dados['data'] = array();
    echo json_encode($dados);
}
