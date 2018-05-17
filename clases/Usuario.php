<?php

namespace App;

use \PDO as PDO;

class Usuario extends Jugador
{
    private $identificador;
    private $clave;

    public static function recuperaUsuarioPorCredencial(PDO $bd, string $identificador, string $clave): ?Usuario
    {
        $sql = 'select * from usuarios where identificador=:identificador and clave=:clave';
        $sth = $bd->prepare($sql);
        $sth->execute([":identificador" => $identificador, ":clave" => $clave]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        return $usuario;
    }

    public function __construct()
    {
        
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador)
    {
        $this->identificador = $identificador;
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
