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

        require_once './Controllers/ItensController.php';
        $ItensController = new ItensController;
    } 
    // if((strtoupper($_SESSION['NOME_USUARIO']) == "ADMIN") || (strtoupper($_SESSION['NOME_USUARIO']) == "DEV")) 
    // {   
    // }  else{
    //     $Routes->Home();
    // }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
    <link rel="stylesheet" href="css\Home.css">
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
                                Consulta Itens!
                            </div>                    
                        </div>
                        <div id="Grid" class="Grid">
                            <form method="GET">
                                <?php                        
                                    echo $ItensController->BuscarItens();
                                ?>    
                            </form>                                                
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>