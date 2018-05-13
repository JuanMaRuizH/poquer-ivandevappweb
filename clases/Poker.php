<?php
namespace App;

class Poker
{
    private $jugador1;
    private $jugador2;
    private $baraja;

    public function __construct(Usuario $usuario)
    {
        
    }

    public function reparteCartas(): void
    {
        
    }

    public function getJugador1(): Jugador
    {
        return $this->jugador1;
    }

    public function setJugador1(Jugador $jugador): void
    {
        $this->jugador1 = $jugador;
    }

    public function getJugador2(): Jugador
    {
        return $this->jugador2;
    }

    public function setJugador2(Jugador $jugador): void
    {
        $this->jugador2 = $jugador;
    }

    public function valorJugada(Vector $jugada) : int
    {

    }

    public function ganador(): Jugador
    {

    }


}
