<?php
    session_start();
    require_once '../Class/Routes.php';
    $Routes = new Routes;  
    
    $msg = "";

    if(!empty($_GET['id']))
    {   
        echo $_GET['id'];
        
        require_once "../Class/BancoDados.php";
        $BancoDados = new BancoDados;
        $BancoDados->conectarBanco();
        global $db;

        $id = $_GET['id'];
        $user = $_SESSION['ID_USUARIO'];

        $sql = $db->prepare("SELECT EMPR.IDEMPRESTIMO FROM TBEMPRESTIMOS AS EMPR 
        WHERE EMPR.IDUSUARIO = '$user'
        AND EMPR.IDITEM = '$id'
        AND EMPR.IDSITUACAO = 3");
        $sql->execute();

        if($sql->rowCount() <= 0)
        {
            echo "\nEmprestando...\n";
            
            if(isset($_POST['Quantidade']))
            {
                echo "- ".$_POST["Quantidade"];
            }else{
                echo "\nNÃO";
            }
            // $dado=$sql->fetch();
            // $sql = $db->prepare("INSERT INTO TBEMPRESTIMOS (IDUSUARIO,IDITEM,QUANTIDADE,DATAEMPRESTIMO,DATADEVOLUCAO,IDSITUACAO) VALUES (:User,:Item,:Qtd,:DtEmp,:DtDev,3);");
            // $sql->bindValue(":User",$user);
            // $sql->bindValue(":Item",$id);
            // $sql->bindValue(":Qtd",$parNome);
            // $sql->bindValue(":DtEmp",$parNome);
            // $sql->bindValue(":DtDev",$parNome);
            // $sql->execute();

        }else
        {          
            //header("location: RealizarEmprestimo.php?erro=1");
        }
    }else{
        //header("location: RealizarEmprestimo.php?erro=2");
    }
//$Routes->RealizarEmprestimo();
?> 