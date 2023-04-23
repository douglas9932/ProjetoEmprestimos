<?php

Class BancoDados{
    
    
    public $db;
    public $msgErro="";
    public function conectarBanco(){
        try{
            
             $NomeBanco = "bancosistemawebatp";
             $HostBanco ="localhost";
             $Usuario ="root";
             $Senha ="1234";
            
            global $db;
            $db = new PDO("mysql:dbname=".$NomeBanco.";host=".$HostBanco,$Usuario,$Senha);            
        }catch(PDOException $e){
            ?>
            <script>alert($e);</script>
            <?php
            $msgErro = $e->getMessage();
        }
    }
}
?>