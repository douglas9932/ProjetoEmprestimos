<?php

Class Routes{
    
    public function Login()
    {
        $_SESSION['EDITARUSUARIO'] = "false";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: Login.php");
    }

    public function Home()
    { 
        $_SESSION['EDITARUSUARIO'] = "false";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: Home.php");
    }

    public function EditarUsuario()
    {
        $_SESSION['EDITARUSUARIO'] = "true";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: CadastrarUsuario.php");
    }

    public function CadastrarItem()
    {   $_SESSION['EDITARUSUARIO'] = "false";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: CadastrarItem.php");
    }

    public function ConsultarItens()
    {   $_SESSION['EDITARUSUARIO'] = "false";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: ConsultarItens.php");
    }

    public function CadastrarUsuario()
    {   
        $_SESSION['EDITARUSUARIO'] = "false";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: CadastrarUsuario.php");
    }

    public function ConsultarUsuarios()
    {   
        $_SESSION['EDITARUSUARIO'] = "false";
        $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        header("location: ConsultarUsuarios.php");
    }

    public function RealizarEmprestimo()
    { 
        if($_SESSION['EDITAR_EMPRESTIMO'] == "true"){
            $_SESSION['EDITAR_EMPRESTIMO'] = "false";
        }
        header("location: RealizarEmprestimo.php");
    }
    public function EditarEmprestimo()
    { 
        $_SESSION['EDITAR_EMPRESTIMO'] = "true";           
        header("location: RealizarEmprestimo.php");
    }
}

?>