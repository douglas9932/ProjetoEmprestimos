<?php
    
Class ItensController{

    public $msgErro="";

    public function BuscarItens(){
        require_once ".././Class/BancoDados.php";
        $BancoDados = new BancoDados;
        $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root"); 

        $table ="";
        global $db;

        try{
            $sql = $db->prepare(" SELECT ITEM.DESCRICAO AS DESCRICAOITEM
            ,ITEM.QUANTIDADE
            ,ITEM.VALOR
            ,SIT.DESCRICAO
            FROM TBITENS AS ITEM
            INNER JOIN TBSITUACAO AS SIT ON SIT.IDSITUACAO = ITEM.IDSITUACAO ");
            
            $sql->execute();

            $StyleRow = "class='row-data'";

            if($sql->rowCount() > 0)
            {
                $table  = "<table class='table'>";
                $table .= "<thead>";
                $table .= "<tr>";
                $table .= "<td>Descrição do Produto</td>";
                $table .= "<td>Quantidade</td>";
                $table .= "<td>Valor</td>";
                $table .= "<td class='row-data alignCenter' >Situação</td>";
                $table .= "</tr>";
                $table .= "</thead>";
                $table .= "<tbody>";
                // Agora o resultado 
                while($dado=$sql->fetch()) 
                {
                $table .= "<tr>"; 
                $table .= "<td ".$StyleRow.">".$dado["DESCRICAOITEM"]."</td>";
                $table .= "<td ".$StyleRow.">".$dado["QUANTIDADE"]."</td>";
                $table .= "<td ".$StyleRow.">".$dado["VALOR"]."</td>";
                $table .= "<td class='row-data alignCenter' >".$dado["DESCRICAO"]."</td>";                
                $table .= "</tr>";
                }

                $table .= "</tbody>";
                $table .= "</table>";

                return $table;
            
            }else
            {   
                $table = "<div class='NenhumDadoEncontrado' >Nenhum Item Cadastrado!</div>";
                return $table;
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }

    public function CadastrarItem($parDescricao,$parQuantidade,$parValor){
        global $db;
        try{
            $sql = $db->prepare("SELECT ITEM.DESCRICAO FROM TBITENS AS ITEM WHERE ITEM.DESCRICAO = :D");
            $sql->bindValue(":D",$parDescricao);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                return false;            
            }
            else
            {
                $sql=$db->prepare("INSERT INTO TBITENS (DESCRICAO,QUANTIDADE,VALOR,IDSITUACAO) VALUES (:descricao, :quantidade, :valor,1)");
                $sql->bindValue(":descricao",strtoupper($parDescricao)); 
                $sql->bindValue(":quantidade", $parQuantidade);
                $sql->bindValue(":valor", str_replace(",",".",$parValor));
                $sql->execute();
                return true;
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }
}?>