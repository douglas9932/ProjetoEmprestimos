<?php

	session_start();

	require_once '../Class/Usuarios.php';
	$User = new Usuarios;

	require_once '../Class/BancoDados.php';
	$BancoDados = new BancoDados;

	require_once '../Class/Routes.php';
	$Routes = new Routes;

	
	$_SESSION['EDITARUSUARIO']="false";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="css/Login.css">
</head>
<body>
	<div id="CorpoLogin">
		<h1>Bem Vindo !</h1>
		<form method="POST">	
			<input type="email"  name="email" placeholder="Usuário">
			<input type="password"  name="senha" placeholder="Senha">
			<button type="submit" >Entrar</button>
			<a href="Cadastrar.php">Cadastrar-se</a>
		</form>

		<?php
	if(isset($_POST['email']))
	{
		$email = addslashes($_POST['email']);
		$senha = addslashes($_POST['senha']);

		if(!empty($email) && !empty($senha))
		{
			$BancoDados->conectarBanco();
			
			if($User->msgErro =="")
			{	
				if($User->Login($email,$senha))
				{
					?>
					<div class="msg_Sucesso">
					Loading.....
					</div>
					<?php
					$Routes->Home();					
				}
				else
				{
					?>
					<div class="msg_Alert">
					Email e/ou senha estão incorretos!!
					</div>
					<?php					
				}
			}
			else
			{
				?>
					<div class="msg_Error">
						<?php
							print "Erro: ".$User.msgErro;
						?>
					</div>
				<?php				
			}
		}
		else
		{
			?>
				<div class="msg_Alert">
				Informe um Email e senha para realizar o Login!
				</div>
			<?php
		}
	}
?>
	</div>
</body>
</html>