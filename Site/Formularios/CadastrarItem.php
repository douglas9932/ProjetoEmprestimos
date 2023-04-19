<?php
    session_start();
    
    require_once '../Class/Routes.php';
    $Routes = new Routes;

    if(!isset($_SESSION['ID_USUARIO']))
    {
        $Routes->Login();
        exit;
    }
    else
    {
        require_once '../Class/Usuarios.php';
	    $User = new Usuarios;

        require_once 'Controllers/ItensController.php';
	    $ItensController = new ItensController;

        require_once '../Class/BancoDados.php';
	    $BancoDados = new BancoDados;

    }     
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
    <link rel="stylesheet" href="css\CadastrarItem.css">
    <link rel="stylesheet" href="css\Home.css">
</head>
<body>
    <div class="Home">
        <div class="form">
                <?php
                include "includes/Menu.php"           
                ?>
                <div id="PaginaAtual" class="PaginaAtual">
                    <div class="Titulo">
                    CADASTRAR ITENS!
                    </div>
                    <div class="Componentes">
                        <form method="POST">
                            <div>
                                <input type="text" class="Descricao" name="Descricao" placeholder="Descrição" maxlength="30">
                                <input type="text" class="Quantidade" name="Quantidade" placeholder="Quantidade" maxlength="30">
                                <input type="text"  class="Valor" name="Valor" placeholder="Valor" maxlength="30">	
                            </div>    
                            <div>
                                <button type="submit" class="Cadastrar">Cadastrar</button>
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['Descricao']))
                            {
                                $Descricao = addslashes($_POST['Descricao']);
                                $Quantidade= addslashes($_POST['Quantidade']);
                                $Valor= addslashes($_POST['Valor']);

                                if(!empty($Descricao) && !empty($Quantidade) && !empty($Valor))
                                {
                                    $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root");

                                    if($ItensController->CadastrarItem($Descricao,$Quantidade,$Valor))
                                    {
                                        ?>
                                            <div class="msg_Sucesso">
                                            Cadastrado com sucesso!!
                                            </div>
                                        <?php	
                                        sleep(3);
                                        $Routes->CadastrarItem();
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="msg_Error">
                                            Produto já Cadastrado!
                                            </div>
                                        <?php
                                    }                                   
                                }
                                else
                                {
                                    ?>
                                        <div class="msg_Alert">
                                        Preencha todos os Campos!
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>