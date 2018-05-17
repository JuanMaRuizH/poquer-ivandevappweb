<?php
namespace App;

class Poker
{
    private $jugador1;
    private $jugador2;
    private $baraja;

    public function __construct(Usuario $usuario)
    {
        $this->setJugador1($usuario);
        $this->setJugador2(new Jugador());
        $this->baraja = new Baraja();
        $this->reset();
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


    public function getBaraja(): Baraja
    {
        return $this->baraja;
    }

    public static function convertirValorHex(string $val): string
    {
        switch ($val) {
            case "A":
            return "E";
            break;
            case "K":
            return "D";
            break;
            case "Q":
            return "C";
            break;
            case "J":
            return "B";
            break;
            case "10":
            return "A";
            break;
           default:
           return $val;

        }
    }

    public function valorJugada(array $jugada) : string
    {
        foreach ($jugada as $carta) {
            $cartasPorPalo[$carta->getPalo()][] = $carta->getValor();
            $cartas[] = self::convertirValorHex($carta->getValor());
        }
        
        $valoresRep = array_count_values($cartas);
        krsort($valoresRep, SORT_STRING);
       

        // Regla Poquer
        if (array_keys($valoresRep, 4)) {
            $valor = "7" . array_keys($valoresRep, 4)[0];
        }
        // Regla Full o Trío
        elseif (array_keys($valoresRep, 3)) {
            if (array_keys($valoresRep, 2)) {
                $valor = "6" . array_keys($valoresRep, 3)[0];
            } else {
                $valor = "3" . array_keys($valoresRep, 3)[0];
            }
        } elseif (array_keys($valoresRep, 2)) {
            if (count(array_keys($valoresRep, 2)) == 2) {
                $valor = "2" . array_keys($valoresRep, 2)[0] . array_keys($valoresRep, 2)[1] . array_keys($valoresRep, 1)[0];
            } else {
                $valor = "1" . array_keys($valoresRep, 2)[0] . array_keys($valoresRep, 1)[0] . array_keys($valoresRep, 1)[1] . array_keys($valoresRep, 1)[2];
            }
        } elseif (count($cartasPorPalo) === 1) {
            if (hexdec(array_keys($valoresRep, 1)[0]) - hexdec(array_keys($valoresRep, 1)[4]) == 4) {
                if (array_keys($valoresRep, 1)[0] === "E") {
                    $valor = "9";
                } else {
                    $valor = "8" . array_keys($valoresRep, 1)[0];
                }
            } else {
                $valor = "5" . array_keys($valoresRep, 1)[0] . array_keys($valoresRep, 1)[1] . array_keys($valoresRep, 1)[2] . array_keys($valoresRep, 1)[3] . array_keys($valoresRep, 1)[4];
            }
        } elseif (hexdec(array_keys($valoresRep, 1)[0]) - hexdec(array_keys($valoresRep, 1)[4]) == 4) {
            $valor = "4" . array_keys($valoresRep, 1)[0];
        } else {
            $valor = "0" . array_keys($valoresRep, 1)[0] . array_keys($valoresRep, 1)[1] . array_keys($valoresRep, 1)[2] . array_keys($valoresRep, 1)[3] . array_keys($valoresRep, 1)[4];
        }
        
        return $valor;
    }

    public function ganador(): ?Jugador
    {
        $valor1 = $this->valorJugada($this->getJugador1()->getJugada());
        $valor2 = $this->valorJugada($this->getJugador2()->getJugada());
        return ((strcmp($valor2, $valor1) < 0) ? $this->getJugador1() : $this->getJugador2());
    }

    public function reset(): void
    {
        $this->getBaraja()->reset();
        $this->getJugador1()->setJugada($this->getBaraja()->dameCartas(5));
        $this->getJugador2()->setJugada($this->getBaraja()->dameCartas(5));
    }
}
