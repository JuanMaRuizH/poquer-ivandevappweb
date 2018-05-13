<?php
namespace App;

use \DS\Vector;
class Jugador
{
    private $jugada;

    }

    public function __construct()
    {
        
    }

    public function getJugada(): Vector
    {
        return $this->identificador;
    }

    public function setJugada(Vector $jugada)
    {
        $this->jugada = $jugada;
    }


}
