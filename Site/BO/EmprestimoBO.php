<?php

Class EmprestimoBO{

    private int $IDEMPRESTIMO;
    private string $DESCRICAO;
    private int $QUANTIDADE;
    private string $NOMEUSUARIO;
    private string $TELEFONEUSUARIO; 
    private string $DATAEMPRESTIMO;
    private string $DATADEVOLUCAO;
    private string $SITUACAO;

    public function setIDEMPRESTIMO($parIDEMPRESTIMO){
        $this->IDEMPRESTIMO = $parIDEMPRESTIMO;
        return $this;

    }
    public function getIDEMPRESTIMO(){
        return $this->IDEMPRESTIMO;
    }

}?>