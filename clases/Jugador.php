<?php
namespace App;

class Jugador
{
    private $jugada;

    

    public function __construct()
    {
        
    }

    public function getJugada(): array
    {
        return $this->jugada;
    }

    public function setJugada(array $jugada)
    {
        $this->jugada = $jugada;
    }


}
