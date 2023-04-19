<?php
    session_start();
    require_once '../Class/Routes.php';
    $Routes = new Routes;  
    
 if(!empty($_GET['id']))
 {   
    echo $_GET['id'];
  
    require_once "../Class/BancoDados.php";
    $BancoDados = new BancoDados;
    $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root");
    global $db;

     $id = $_GET['id'];
     $user = $_SESSION['ID_USUARIO'];

     $sql = $db->prepare("SELECT EMPR.IDEMPRESTIMO FROM TBEMPRESTIMOS AS EMPR  WHERE EMPR.IDUSUARIO = '$user' AND EMPR.IDEMPRESTIMO = '$id'");
     $sql->execute();

     if($sql->rowCount() > 0)
     {
        $dado=$sql->fetch();

        $SituacaoDevolvido = 4;
        $IdEmprestimo = $dado["IDEMPRESTIMO"];
        $sql = $db->prepare("UPDATE TBEMPRESTIMOS SET IDSITUACAO = '$SituacaoDevolvido'  WHERE IDEMPRESTIMO = '$IdEmprestimo'");
        $sql->execute();

    }else
    {
        echo "Empréstimo Não Encontrado!";
    }
 }
$Routes->Home();
?> 