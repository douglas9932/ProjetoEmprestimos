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

        require_once './Controllers/HomeController.php';
        $HomeController = new HomeController;
        
    }     
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
    <link rel="stylesheet" href="css\Home.css">

    <script src="https://kit.fontawesome.com/fe30f843d3.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="Home">
        <div class="form">
                <?php
                include "includes/Menu.php"           
                ?>

                <div id="PaginaAtual" class="PaginaAtual">
                    <div class="Filtros">      
                        <div class="TituloFormulario">
                            Empréstimos Realizados!
                        </div>                    
                    </div>
                    <div id="Grid" class="Grid">                        
                            <?php   
                                print $HomeController->BuscaEmprestimos();                
                            ?>                               
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>