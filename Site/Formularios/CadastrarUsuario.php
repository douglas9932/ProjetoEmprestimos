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
    <link rel="stylesheet" href="css\CadastrarUsuario.css">
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
                        <?php 
                            if($_SESSION['EDITARUSUARIO']=="true")
                            {
                                ?>
                                EDITAR CADASTRO DE USUARIO!
                                <?php 
                            }else{                                
                                ?>
                                CADASTRAR USUARIO!
                                <?php
                            }
                        ?>
                    
                    </div>
                    <div class="Componentes">
                        <form method="POST">
                            <?php 
                                if($_SESSION['EDITARUSUARIO']=="true")
                                {
                                    echo $User->EditarUsuario();
                                    
                                }else{                                
                                    ?>
                                    <div>
                                        <input type="text" class="Nome" name="nome" placeholder="Nome Completo" maxlength="30">
                                        <input type="text"  class="Telefone" name="telefone" placeholder="Telefone" maxlength="30">	
                                    </div>                            
                                    <input type="email" class="Email" name="email" placeholder="Email" maxlength="40">
                                    <div>
                                        <input type="password" class="Senha" name="senha" placeholder="Senha" maxlength="20">
                                        <input type="password"  class="ConfSenha" name="confsenha" placeholder="Confirmar Senha"  maxlength="20">
                                        <button type="submit" class="Cadastrar">Cadastrar</button>
                                    </div>
                                    <?php
                                }
                            ?>                            
                        </form>
                        <?php
                            if(isset($_POST['nome']))
                            {
                                $nome = addslashes($_POST['nome']);
                                $telefone= addslashes($_POST['telefone']);
                                $email= addslashes($_POST['email']);
                                $senha= addslashes($_POST['senha']);
                                $confimarSenha= addslashes($_POST['confsenha']);

                                if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confimarSenha))
                                {
                                    $BancoDados->conectarBanco("bancosistemawebatp", "localhost","root","Root");

                                    if($User->msgErro =="")
                                    {	if($senha == $confimarSenha)
                                        {
                                            if($User->CadastrarUsuario($nome,$telefone,$email,$senha))
                                            {
                                                ?>
                                                    <div class="msg_Sucesso">
                                                    Cadastrado com sucesso!!
                                                    </div>
                                                <?php	
                                            }
                                            else
                                            {
                                                ?>
                                                    <div class="msg_Error">
                                                    Email já Cadastrado!
                                                    </div>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <div class="msg_Alert">
                                                As Senhas não são iguais!
                                                </div>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="msg_Error">
                                                <?php
                                                    echo "Erro: ".$User.msgErro;
                                                ?>
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