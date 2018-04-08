<?php


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
        $dados['data']['item'] = $this->get_listadetail($dados['data']['lista']['id']);

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
        $filhos = [];
        foreach($result as $r)
        {
            $r_url = str_replace($this->list,"",$r['url']);
            $url = explode("/",$r_url);
 
            if(count($url)==2)
            {
                array_push($filhos,$r);
            }
        }
        return $filhos;
         
    }


    
    public function insert_myListDetail($item,$status,$mylist_id)
    {

        try{
            $sql ="
                INSERT 
                INTO 
                mylistdetail
                (item, status,mylist_id) VALUES ('{$item}','{$status}','{$mylist_id}')
            ";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $dados['success'] = true;
            $dados['message'] = "Item adicionado com sucesso!";
            $dados['data'] =  $this->get_listadetail($mylist_id);

            return $dados;

    
        }catch(Exception $exc){
           
            $dados['success'] = false;
            $dados['message'] = $exc->getMessage();
            return $dados;

        }

    }


    public function get_listadetail($id)
    {
        $sql ="
            SELECT 
            *
            FROM
                mylistdetail
            WHERE
            mylist_id = {$id}
            
        ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result)
        {
            $dados['success'] = true;
            $dados['message'] = "Lista encontrada!";
            $dados['data']= $result;

            return $dados;
        
        }else{

            $dados['success'] = false;
            $dados['message'] = "Não possui item!";
        }

    }
}



