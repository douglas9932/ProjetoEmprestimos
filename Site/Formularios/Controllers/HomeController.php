<?php

require_once "../BO/EmprestimoBO.php";
 $EmprestimoBO = new EmprestimoBO;


    
Class HomeController{
    
    public $table ="";

    public function BuscaEmprestimos(){

        require_once ".././Class/BancoDados.php";
        $BancoDados = new BancoDados;
        $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root"); 

        global $db;

        try{
            $sql = $db->prepare("SELECT EMPR.IDEMPRESTIMO 
            ,ITENS.DESCRICAO 
            ,EMPR.QUANTIDADE 
            ,USU.NOMEUSUARIO 
            ,USU.EMAILUSUARIO
            ,USU.TELEFONEUSUARIO 
            ,EMPR.DATAEMPRESTIMO 
            ,EMPR.DATADEVOLUCAO 
            ,EMPR.IDSITUACAO
            ,SIT.DESCRICAO AS SITUACAO 
            FROM TBEMPRESTIMOS AS EMPR 
            INNER JOIN TBITENS AS ITENS ON ITENS.IDITEM = EMPR.IDITEM 
            INNER JOIN TBUSUARIOS AS USU ON USU.IDUSUARIO = EMPR.IDUSUARIO 
            INNER JOIN TBSITUACAO AS SIT ON SIT.IDSITUACAO = EMPR.IDSITUACAO 
            WHERE USU.IDUSUARIO = :idusuario ");
            
            $sql->bindValue(":idusuario",$_SESSION['ID_USUARIO']);
            $sql->execute();

            $StyleRow = "class='row-data'";
            
            $Color = "";

            if($sql->rowCount() > 0)
            {
                $table  = "<table class='table'>";
                $table .= "<thead>";
                $table .= "<tr>";
                $table .= "<td>Item</td>";
                $table .= "<td>Quantidade</td>";
                $table .= "<td>Usuário</td>";
                $table .= "<td>Email</td>";
                $table .= "<td>Telefone</td>";
                $table .= "<td>Data Empréstimo</td>";
                $table .= "<td>Data Devolução</td>";
                $table .= "<td>Situação</td>";
                $table .= "<td>Editar</td>";
                $table .= "<td>Devolver</td>";
                $table .= "</tr>";
                $table .= "</thead>";
                $table .= "<tbody>";

                while($dado=$sql->fetch()) 
                {
                    if($dado["SITUACAO"] == "EMPRESTADO"){
                        if(date('d-m-Y', strtotime(date('d-m-Y'))) > date("d-m-Y", strtotime($dado["DATADEVOLUCAO"]))){
                            $StyleRow = "class='row-data ItemAtrasado'";
                            $Color="ItemAtrasado";
                        }else if(date('d-m-Y', strtotime(date('d-m-Y'))) == date("d-m-Y", strtotime($dado["DATADEVOLUCAO"]))){                       
                            $StyleRow = "class='row-data ItemDevolverHoje'";
                            $Color = "ItemDevolverHoje";
                        }
                    }                    
                    $table .= "<tr>"; 
                    $table .= "<td ".$StyleRow.">".$dado["DESCRICAO"]."</td>";
                    $table .= "<td class='row-data ".$Color." alignCenter' >".$dado["QUANTIDADE"]."</td>";
                    $table .= "<td ".$StyleRow.">".$dado["NOMEUSUARIO"]."</td>";
                    $table .= "<td ".$StyleRow.">".$dado["EMAILUSUARIO"]."</td>";
                    $table .= "<td ".$StyleRow.">".$dado["TELEFONEUSUARIO"]."</td>";
                    $table .= "<td ".$StyleRow.">".date("d/m/Y", strtotime($dado["DATAEMPRESTIMO"]))."</td>";
                    $table .= "<td ".$StyleRow.">".date("d/m/Y", strtotime($dado["DATADEVOLUCAO"]))."</td>";
                    $table .= "<td ".$StyleRow." >".$dado["SITUACAO"]."</td>";

                    $table .="<form method='POST'>";
                    if($dado['IDSITUACAO'] ==4){
                        $table .= "<td class='alignCenter ".$Color." CollButton'>"."<a><img class='' src='../Imagens/Grid/Edit.svg'>"."</td>";
                    }else{
                        $table .= "<td class='alignCenter ".$Color." CollButton'>"."<a href='EditarEmprestimo.php?id=$dado[IDEMPRESTIMO]'><img class='' src='../Imagens/Grid/Edit.svg'>"."</td>";
                    }
                    $table .= "</form>";
                    $table .="<form method='GET'>";
                    $table .= "<td class='alignCenter ".$Color." CollButton'>"."<a href='Devolver.php?id=$dado[IDEMPRESTIMO]'><img class='' src='../Imagens/Grid/Devolver.svg' >"."</td>";
                    $table .= "</form>";
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
}