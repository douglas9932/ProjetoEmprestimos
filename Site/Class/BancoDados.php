<?php

Class BancoDados{
    public $db;
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
}
?>