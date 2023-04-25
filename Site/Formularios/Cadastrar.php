<?php
	require_once '../Class/Usuarios.php';
	$User = new Usuarios;

	require_once '../Class/Routes.php';
	$Routes = new Routes;

	require_once '../Class/BancoDados.php';
	$BancoDados = new BancoDados;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ATP Douglas Tescaro Candido da Silva</title>
	<link rel="stylesheet" href="css/Cadastrar.css">
</head>
<body>
	<div id="CorpoLogin">
		<h1>Cadastrar</h1>
		<form method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
            <input type="text"  name="telefone" placeholder="Telefone" maxlength="30">	
			<input type="email" name="email" placeholder="Email" maxlength="40">
			<input type="password" name="senha" placeholder="Senha" maxlength="20">
            <input type="password"  name="confsenha" placeholder="Confirmar Senha"  maxlength="20">
			<button type="submit" >Cadastrar</button>
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
			$BancoDados->conectarBanco();

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
						$Routes->Login();			
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
				Preencha todos os Campos!
				</div>
			<?php
		}
	}
?>

	</div>
</body>
</html>