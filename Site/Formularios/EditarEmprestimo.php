<?php
    session_start();
    require_once '../Class/Routes.php';
    $Routes = new Routes;  
    
 if(!empty($_GET['id']))
 { 
    $_SESSION['EDITAR_EMPRESTIMO'] = "true";
    $_SESSION['EDITAR_IDEMPRESTIMO'] = $_GET['id'];

    echo $_SESSION['EDITAR_EMPRESTIMO'];
    echo $_SESSION['EDITAR_IDEMPRESTIMO'];

    $Routes->EditarEmprestimo();

 }