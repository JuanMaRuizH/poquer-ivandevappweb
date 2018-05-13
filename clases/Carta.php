<?php

namespace App;

class Carta
{
    private $valor;
    private $palo;


    public function __construct(string $valor, string $palo)
    {
        
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
