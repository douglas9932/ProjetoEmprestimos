<?php

   

Class Usuarios{
    
    private  $db;
    public $msgErro="";
    public function conectarBanco($parNome, $parHost, $parUsuario, $parSenha){
        try{
            global $db;
            $db = new PDO("mysql:dbname=".$parNome.";host=".$parHost,$parUsuario,$parSenha);            
        }catch(PDOException $e){
            ?>
            <script>alert($e);</script>
            <?php
            $msgErro = $e->getMessage();
        }
    }

    public function CadastrarUsuario($parNome,$parTelefone,$parEmail,$parSenha){

        require_once '.././Class/Routes.php';
        $Routes = new Routes;

        global $db;
        try{
            
            if(isset($_SESSION['EDITARUSUARIO']) && $_SESSION['EDITARUSUARIO']=="true")
            {
                $IDUser = $_SESSION['ID_USUARIO'];
                $sql=$db->prepare("UPDATE TBUSUARIOS SET NOMEUSUARIO = '$parNome',TELEFONEUSUARIO='$parTelefone',EMAILUSUARIO='$parEmail',SENHAUSUARIO='$parSenha' WHERE IDUSUARIO='$IDUser'");
                $sql->execute();
                $_SESSION['EDITARUSUARIO'] = "false";
                
                $Routes->Home();
                return true;             
            }else if(!isset($_SESSION['EDITARUSUARIO']) || $_SESSION['EDITARUSUARIO']=="false"){

                $sql = $db->prepare("SELECT IDUSUARIO FROM TBUSUARIOS WHERE EMAILUSUARIO = :e");
                $sql->bindValue(":e",$parEmail);
                $sql->execute();

                if($sql->rowCount() > 0)
                {                
                    return false;            
                }
                else
                {
                    $sql=$db->prepare("INSERT INTO TBUSUARIOS (NOMEUSUARIO,TELEFONEUSUARIO,EMAILUSUARIO,SENHAUSUARIO,IDSITUACAO) VALUES(:nome, :telefone, :email, :senha, 1) ");
                    $sql->bindValue(":nome",$parNome); 
                    $sql->bindValue(":telefone", $parTelefone);
                    $sql->bindValue(":email", $parEmail);
                    $sql->bindValue(":senha", $parSenha);
                    $sql->execute();

                    $_SESSION['EDITARUSUARIO'] = "false";
                    $Routes->CadastrarUsuario();
                    return true;
                }                 
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }

    public function Login($parEmail,$parSenha){
        global $db;
        try{
            $sql = $db->prepare("SELECT IDUSUARIO, NOMEUSUARIO FROM TBUSUARIOS WHERE EMAILUSUARIO = :email AND SENHAUSUARIO= :senha AND IDSITUACAO = 1");
            $sql->bindValue(":email",$parEmail);
            $sql->bindValue(":senha", $parSenha);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                $dado = $sql->fetch();
                $_SESSION['ID_USUARIO'] = $dado['IDUSUARIO'];
                $_SESSION['NOME_USUARIO'] = $dado['NOMEUSUARIO'];
                return true;
            
            }else
            {
                return false;
            }

        }catch(PDOException $e){
            $msgErro = $e->getMessage();
        }
    }

    public function Sair(){        
        try
        {
            session_start();
            unset($_SESSION['ID_USUARIO']);
            header("location: Login.php");
            
        }catch(Exception $e){
            $msgErro = $e->getMessage();
        }
    }

    public function EditarUsuario(){
        try
        {
            require_once ".././Class/BancoDados.php";
            $BancoDados = new BancoDados;
            $BancoDados->conectarBanco(); 

            global $db;

            $IDUser = $_SESSION['ID_USUARIO'];

            $sql = $db->prepare("SELECT IDUSUARIO, NOMEUSUARIO, EMAILUSUARIO, TELEFONEUSUARIO, SENHAUSUARIO FROM TBUSUARIOS WHERE IDUSUARIO = :id ");
            $sql->bindValue(":id",$IDUser);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                $dado = $sql->fetch();

                $NomeCompleto=$dado['NOMEUSUARIO'];
                $Telefone=$dado['TELEFONEUSUARIO'];
                $Email=$dado['EMAILUSUARIO'];
                $Senha=$dado['SENHAUSUARIO'];
                $confsenha=$dado['SENHAUSUARIO'];                
            }

            return "<div>
                        <input type='text' class='Nome' name='nome' placeholder='Nome Completo' maxlength='30'  Value='".$NomeCompleto."'>
                        <input type='text'  class='Telefone' name='telefone' placeholder='Telefone' maxlength='30'  Value='".$Telefone."'>	
                    </div>                            
                    <input type='email' class='Email' name='email' placeholder='Email' maxlength='40'  Value='".$Email."'>
                    <div>
                        <input type='password' class='Senha' name='senha' placeholder='Senha' maxlength='20'  Value='".$Senha."'>
                        <input type='password'  class='ConfSenha' name='confsenha' placeholder='Confirmar Senha'  maxlength='20'  Value='".$confsenha."'>
                        <button type='submit' class='Cadastrar'>Salvar</button>
                    </div>";

            
            
        }catch(Exception $e){
            $msgErro = $e->getMessage();
        }
    }
}
?>