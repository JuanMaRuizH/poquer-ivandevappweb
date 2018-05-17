<?php

namespace App;

class Carta
{
    
    private $palo;
    private $valor;


    public function __construct(string $palo, string $valor)
    {
        $this->palo = $palo;
        $this->valor = $valor;
        
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $valor)
    {
        $this->valor = $valor;
    }

    public function getPalo(): string
    {
        return $this->palo;
    }

    public function setPalo(string $palo)
    {
        $this->palo = $palo;
    }

}
