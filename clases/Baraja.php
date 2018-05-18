<?php
namespace App;

class Baraja
{
    private $cartas;
    private $numCartas;
    private $numSigCarta;

    const PALOS = ["clubs", "diamonds", "hearts", "spades"];
    const VALORES = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];

    public function __construct()
    {
        foreach (self::PALOS as $palo) {
            foreach (self::VALORES as $valor) {
                $this->anyadeCarta(new Carta($palo, $valor));
            }
        }
        $this->setNumCartas(count(self::PALOS) * count(self::VALORES));
        $this->reset();
    }


    public function anyadeCarta (Carta $carta): void 
    {
        $this->cartas[] = $carta;
    }

    public function dameCartas(int $num): ?array
    {
        while (($num > 0) && ($carta = $this->sigCarta())) {
            $cartas[] = $carta;
            $num--;
        }
        return (($carta) ? $cartas : $carta);
    }

    public function mezcla(): void
    {
        $cartas = $this->getCartas();
        shuffle($cartas);
        $this->setCartas($cartas);
    }

    public function reset(): void
    {
        $this->numSigCarta = 0;
        $this->mezcla();
    }

    public function getNumCartas(): int
    {
        return $this->numCartas;
    }

    public function setNumCartas(int $num): void
    {
        $this->numCartas = $num;
    }

    public function getCartas(): array
    {
        return $this->cartas;
    }

    public function setCartas(array $cartas)
    {
        $this->cartas = $cartas;
    }

    public function sigCarta(): ?Carta
    {
        return (($this->numSigCarta < $this->numCartas) ? $this->cartas[$this->numSigCarta++] : null);
    }
}
