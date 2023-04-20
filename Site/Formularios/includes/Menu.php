<form class="Menu" method="POST">
<button name="BtnHome" class="BtnHome"><img class="ImgHome" src="../Imagens/Botoes/Home.svg"><a> Home</a></button>
<button name="BtnCadastrarItem" class="BtnMenu">Cadastrar Item</button>
<button name="BtnConsultarItens" class="BtnMenu">Consultar Itens</button>
<button name="BtnCadastrarUsuario" class="BtnMenu">Cadastrar Usuarios</button>
<button name="BtnConsultarUsuarios" class="BtnMenu">Consultar Usuarios</button>
<button name="BtnRealizarEmprestimo" class="BtnMenu">Realizar Emprestimo</button>                
</form>

<div class="CorpoPaginaHome">
    <form method="POST">
        <nav  class="NavBar">
            <div>
                <button name="BtnEditarDadosDoUsuario" class="BtnEditar"><img class="imgBtn" src="../Imagens/Botoes/edit.svg"><a>- Editar Cadastro</a></button>
            </div>
            <div>
                <button name="BtnSair" class="BtnSair"><img  class="imgBtn" src="../Imagens/Botoes/logout.svg" ></img></button>
            </div>
        </nav>
    </form>
<?php
    if(isset($_POST['BtnSair']))
    {
        $User->Sair();
    }
    if(isset($_POST['BtnHome']))
	{  
        $Routes->Home();
    }
     if(isset($_POST['BtnEditarDadosDoUsuario']))
	{  
        $Routes->EditarUsuario();
    }
    if(isset($_POST['BtnCadastrarItem']))
	{  
        $Routes->CadastrarItem();
    }
    if(isset($_POST['BtnConsultarItens']))
	{   $Routes->ConsultarItens();
    }
    if(isset($_POST['BtnCadastrarUsuario']))
	{$Routes->CadastrarUsuario();
    }
    if(isset($_POST['BtnConsultarUsuarios']))
	{  $Routes->ConsultarUsuarios();
    }
    if(isset($_POST['BtnRealizarEmprestimo']))
	{  $Routes->RealizarEmprestimo();
    }
?>
