<?php

namespace App;

class Baraja
{
    private cartas;

    public function __construct()
    {
        
    }

    public function dameCarta(): string
    {
        return $this->identificador;
    }

    public function baraja()
    {
       
    }

    public function reset(): Jugada
    {
        
    }



    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave)
    {
        $this->clave = $clave;
    }

}
