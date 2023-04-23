<?php
    
Class UsuariosController{

    public function BuscarUsuarios(){
        require_once ".././Class/BancoDados.php";
        $BancoDados = new BancoDados;
        $BancoDados->conectarBanco(); 

        $table ="";
        global $db;

        try{
            $sql = $db->prepare(" SELECT USU.NOMEUSUARIO
                , USU.EMAILUSUARIO
                , USU.TELEFONEUSUARIO
                , SIT.DESCRICAO
            FROM TBUSUARIOS AS USU
            INNER JOIN TBSITUACAO AS SIT ON USU.IDSITUACAO = SIT.IDSITUACAO ");
            
            $sql->bindValue(":idusuario",$_SESSION['ID_USUARIO']);
            $sql->execute();

            $StyleRow = "class='row-data'";

            if($sql->rowCount() > 0)
            {
                $table  = "<table class='table'>";
                $table .= "<thead>";
                $table .= "<tr>";
                $table .= "<td>Nome</td>";
                $table .= "<td>Email</td>";
                $table .= "<td>Telefone</td>";
                $table .= "<td class='row-data alignCenter' >Situação</td>";
                $table .= "</tr>";
                $table .= "</thead>";
                $table .= "<tbody>";
                // Agora o resultado 
                while($dado=$sql->fetch()) 
                {
                $table .= "<tr>"; 
                $table .= "<td ".$StyleRow.">".$dado["NOMEUSUARIO"]."</td>";
                $table .= "<td ".$StyleRow.">".$dado["EMAILUSUARIO"]."</td>";
                $table .= "<td ".$StyleRow.">".$dado["TELEFONEUSUARIO"]."</td>";
                $table .= "<td class='row-data alignCenter' >".$dado["DESCRICAO"]."</td>";                
                $table .= "</tr>";
                }

                $table .= "</tbody>";
                $table .= "</table>";

                return $table;
            
            }else
            {   
                $table = "<div class='NenhumDadoEncontrado' >Nenhum Empéstimo Realizado!</div>";
                return $table;
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }

}?>