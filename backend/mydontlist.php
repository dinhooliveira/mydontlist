<?php

require_once('conexao.php');

class mylist {
    
    public $list;
    public $url;
    public $conexao;

    public function dontlist()
    {
      
        $this->list = str_replace("/mydontlist/","",$this->url);

        $list = substr($this->list, strlen($this->list)-1, strlen($this->list));
    
        if($list=='/')
        {
            $this->list= substr($this->list, 0, strlen($this->list)-1);
        }
        
        $sql="
          SELECT 
            *
          FROM
              mylist
          WHERE
          url = '{$this->list}'
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result){
            
        $dados['success'] = true;
        $dados['message'] = "lista encontrada";
        $dados['data'] = [];
        $dados['data']['lista'] = $result;
        $dados['data']['filho'] = $this->filho();

        echo json_encode($dados);
           
        } else {
                
            $result = $this->insert();
            $this->dontlist();
        }


        

    }

    public function insert()
    {

        $valores = explode('/',$this->list);

        if(count($valores) > 1)
        {
            $title = array_pop($valores);

        } else {
           $title =$this->list;
        }
    

        $sql="
        INSERT INTO mylist (url,title)
        VALUES('{$this->list}','{$title}')
        ";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function filho()
    {
    
        $sql="
            SELECT 
            * 
            FROM 
                mylist
            WHERE 
                url LIKE '{$this->list}%';
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
         
    }
}




if(isset($_POST['url']) )
{
    //teste de conexao
    $teste = new mylist();
    $teste->url = $_POST['url'];
    $teste->conexao = $pdo;
    $teste->dontlist();
}else{

    $dados['success'] = false;
    $dados['message'] = "Não foi passado parametro POST ";
    $dados['data'] = array();
    echo json_encode($dados);
}