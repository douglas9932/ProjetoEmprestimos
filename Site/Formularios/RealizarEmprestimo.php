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
        
        require_once 'Controllers/EmprestimoController.php';
	    $EmprestimoController = new EmprestimoController;

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
    <link rel="stylesheet" href="css\Home.css">
    <link rel="stylesheet" href="css\RealizarEmprestimo.css">
</head>
<body>
    <div class="Home">
        <div class="form">
                <?php
                include "includes/Menu.php"           
                ?>
                <div id="PaginaAtual" class="PaginaAtual">
                    <?php
                    if($_SESSION['EDITAR_EMPRESTIMO'] == "true"){
                    ?>
                        <div class="Titulo">
                        EDITANDO EMPRÉSTIMO!
                        </div>
                        <div class="Componentes">
                            <form method="POST">
                            <?php
                                echo $EmprestimoController->EditandoEmprestimo();
                            ?>  
                                <div>
                                    <button type="submit" class="Cadastrar">Salvar</button>
                                </div>
                            </form>                       
                        </div>
                    <?php
                    }
                    else{
                        ?>
                            <div class="Titulo">
                            REALIZAR EMPRÉSTIMO!
                            </div>
                            <div class="Componentes">
                                <form method="POST">
                                    <div>
                                        <input type="text" class="Quantidade" name="Quantidade" placeholder="Quantidade" maxlength="30">
                                        <input type="date" class="DataDevolucao" name="DataDevolucao" placeholder="Data Devolução" maxlength="30">
                                    </div> 
                                    <div>
                                    <?php                        
                                            echo $EmprestimoController->BuscarItens();
                                    ?> 
                                    </div>   
                                    <div>
                                    <?php
                                    ?>
                                        <button type="submit" class="Cadastrar">Emprestar</button>
                                    </div>
                                </form>                       
                            </div>
                        <?php
                    }
                    ?>

                    <?php
                    if($_SESSION['EDITAR_EMPRESTIMO'] =="true"){
                        if(isset($_POST['Quantidade']))
                        {
                            $Quantidade= addslashes($_POST['Quantidade']);
                            $DataDevolucao = addslashes($_POST['DataDevolucao']);                                
                            $DataDevolucao = date_format(date_create($DataDevolucao),'d/m/Y');

                            $DataHoraAgora = date('d-m-Y', strtotime(date('d-m-Y'). ' -1 days'));
                            $DataHoraAgora = str_replace("-","/", $DataHoraAgora);
                                                        
                            if($Quantidade == "0"){
                                ?>
                                <div class="msg_Alert">
                                Quantidade não pode ser menor que 0!
                                </div>
                            <?php	

                                return;
                            }
                            if($DataDevolucao ==""){
                                ?>
                                <div class="msg_Alert">
                                Informe uma Data de Devolução Para Realizar um empréstimo!
                                </div>
                            <?php	
                                return;
                            }
                            if($DataDevolucao <= $DataHoraAgora){
                                ?>
                                <div class="msg_Alert">
                                Data De Devolução não pode ser menor ou igual que a Data de hoje!!
                                </div>
                            <?php	
                                return;
                            }else{
                                
                                if(!empty($DataDevolucao) && !empty($Quantidade))
                                {
                                    $BancoDados->conectarBanco();

                                    if($EmprestimoController->RealizaEmprestimo($DataDevolucao,$Quantidade,0))
                                    {
                                        ?>
                                            <div class="msg_Sucesso">
                                                Empéstimo Realizado com Sucesso!!
                                            </div>
                                            <?php	
                                        sleep(3);
                                        $Routes->Home();
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="msg_Alert">
                                            Você já possui um empréstimo desse item Não Devolvido!                                                    
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
                        }
                    }else{                       
                        if(isset($_POST['Quantidade']))
                        {
                            $Quantidade= addslashes($_POST['Quantidade']);
                            $DataDevolucao = addslashes($_POST['DataDevolucao']);                                
                            $DataDevolucao = date_format(date_create($DataDevolucao),'d/m/Y');

                            $DataHoraAgora = date('d-m-Y', strtotime(date('d-m-Y'). ' -1 days'));
                            $DataHoraAgora = str_replace("-","/", $DataHoraAgora);
                            
                            $Item = addslashes($_POST['SelectItem']);
                            
                            if($Quantidade == "0"){
                                ?>
                                <div class="msg_Alert">
                                Quantidade não pode ser menor que 0!
                                </div>
                            <?php	

                                return;
                            }
                            if($DataDevolucao ==""){
                                ?>
                                <div class="msg_Alert">
                                Informe uma Data de Devolução Para Realizar um empréstimo!
                                </div>
                            <?php	
                                return;
                            }
                            if($DataDevolucao <= $DataHoraAgora){
                                ?>
                                <div class="msg_Alert">
                                Data De Devolução não pode ser menor ou igual que a Data de hoje!!
                                </div>
                            <?php	
                                return;
                            }else{
                                
                                if(!empty($DataDevolucao) && !empty($Quantidade))
                                {
                                    $BancoDados->conectarBanco();

                                    if($EmprestimoController->RealizaEmprestimo($DataDevolucao,$Quantidade,$Item))
                                    {
                                        ?>
                                            <div class="msg_Sucesso">
                                                Empéstimo Realizado com Sucesso!!
                                            </div>
                                            <?php	
                                        sleep(3);
                                        $Routes->RealizarEmprestimo();
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="msg_Alert">
                                                Você já possui um empréstimo desse item Não Devolvido!                                                    
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
                        }
                    }
                        ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>