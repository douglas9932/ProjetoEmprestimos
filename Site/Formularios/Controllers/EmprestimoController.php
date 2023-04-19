<?php
    
Class EmprestimoController{

    public $msgErro="";
    public $Mensagem ="";
    
    public function BuscarItens(){
        require_once ".././Class/BancoDados.php";
        $BancoDados = new BancoDados;
        $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root"); 

        $table ="";
        global $db;

        try{
            $sql = $db->prepare(" SELECT 
            ITEM.IDITEM
            ,ITEM.DESCRICAO AS DESCRICAOITEM
            ,ITEM.QUANTIDADE
            ,ITEM.VALOR
            ,SIT.DESCRICAO
            FROM TBITENS AS ITEM
            INNER JOIN TBSITUACAO AS SIT ON SIT.IDSITUACAO = ITEM.IDSITUACAO ");
            
            $sql->execute();

            $StyleRow = "class='row-data'";

            if($sql->rowCount() > 0)
            {
                $Drop = "";
                $Drop .= "<select class='SelectItens' name='SelectItem'>";
                
                while($dado=$sql->fetch()) 
                {
                $Drop .= "<option value='$dado[IDITEM]'>$dado[DESCRICAOITEM]</option>" ;
                }
                $Drop .= "</select>";

                return $Drop;

            }else
            {   
                $table = "<div class='NenhumDadoEncontrado' >Nenhum Item Cadastrado!</div>";
                return $table;
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }

    public function RealizaEmprestimo($DataDevolucao,$parQuantidade,$parIDItem){
        global $db;
        try{
         
            if($_SESSION['EDITAR_EMPRESTIMO'] =="true"){
                
                if($parIDItem ==0 && $_SESSION['EDITAR_IDEMPRESTIMO'] != 0){

                    if($DataDevolucao != ""){
                        $DataDevolucao = str_replace("/","-",$DataDevolucao);
                        $DataDevolucao = date_format(date_create($DataDevolucao),'Y-m-d H:i:s');
                    }

                    $IDEMPRESTIMO = $_SESSION['EDITAR_IDEMPRESTIMO'];

                    $sql = $db->prepare(" UPDATE TBEMPRESTIMOS SET 
                    QUANTIDADE = '$parQuantidade' 
                    ,DATADEVOLUCAO ='$DataDevolucao' 
                    WHERE IDEMPRESTIMO = '$IDEMPRESTIMO' ");
                    $sql->execute();

                    return true;
                }else{
                    return false;   
                }



            }else{                
                $user = $_SESSION['ID_USUARIO'];
                $sql = $db->prepare("SELECT EMPR.IDEMPRESTIMO FROM TBEMPRESTIMOS AS EMPR 
                WHERE EMPR.IDUSUARIO = '$user'
                AND EMPR.IDITEM = '$parIDItem'
                AND EMPR.IDSITUACAO = 3");
                $sql->execute();

                if($sql->rowCount() > 0)
                {
                    return false;            
                }
                else
                {
                    if($DataDevolucao != ""){
                        $DataDevolucao = str_replace("/","-",$DataDevolucao);
                        $DataDevolucao = date_format(date_create($DataDevolucao),'Y-m-d H:i:s');
                    }
                    
                    $sql = $db->prepare("INSERT INTO TBEMPRESTIMOS (IDUSUARIO,IDITEM,QUANTIDADE,DATAEMPRESTIMO,DATADEVOLUCAO,IDSITUACAO) VALUES (:user, :IDItem, :Quantidade, NOW(), :DataDevolucao, 3) ");
                    $sql->bindValue(":user",$user);
                    $sql->bindValue(":IDItem",$parIDItem);
                    $sql->bindValue(":Quantidade",$parQuantidade);
                    $sql->bindValue(":DataDevolucao",$DataDevolucao);
                    $sql->execute();

                    return true;
                }
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }

    public function EditandoEmprestimo(){

        require_once ".././Class/BancoDados.php";
        $BancoDados = new BancoDados;
        $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root"); 
        
        global $db;
        $Componentes ="";

        $IDEMPRESTIMO = $_SESSION['EDITAR_IDEMPRESTIMO'];

        try{
            $sql = $db->prepare(" SELECT EMPR.IDEMPRESTIMO 
            ,EMPR.QUANTIDADE 
            ,EMPR.DATADEVOLUCAO 
            ,ITEM.DESCRICAO 
            FROM TBEMPRESTIMOS AS EMPR 
            INNER JOIN TBITENS AS ITEM  ON ITEM.IDITEM = EMPR.IDITEM 
            WHERE EMPR.IDEMPRESTIMO = '$IDEMPRESTIMO' ");
            $sql->execute();
            

            $StyleRow = "class='row-data'";

            if($sql->rowCount() > 0)
            {
                $dado=$sql->fetch();

                $data = date_format(date_create($dado['DATADEVOLUCAO']),'Y-m-d');
                $Componentes= "                 
                    <div>
                        <input type='text' class='Quantidade' name='Quantidade' placeholder='Quantidade' maxlength='30' value='$dado[QUANTIDADE]'>
                        <input type='date' class='DataDevolucao' name='DataDevolucao' placeholder='Data Devolução' maxlength='30' value='$data'>
                    </div> 
                    <div>
                        <input type='text' class='EdtDescricaoItem' name='EdtItem' disabled value='$dado[DESCRICAO]'>
                    </div>
                    ";
                 return $Componentes;

            }else
            {   
                return $Componentes;
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
      
    }
}?>