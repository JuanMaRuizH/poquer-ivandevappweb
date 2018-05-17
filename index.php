<?php

/*
 * A continuación se detallan los mensajes que le pueden llegar
 * al controlador y la lógica de proceso para cada uno de ellos.
 *
 * - Si la petición proviene de un usuario ya validado
 *   - Proceso Cerrar Sesión
 *      -- Eliminar la sesión PHP
 *      -- Mostrar la vista "formlogin" con el formulario de login
 *   - Petición de volver a jugar
 *      
 *   - En otro caso
 *      -- Recuperar el usuario que tiene la sesión abierta
 *      -- Pediro al usuario un cuadro aleatorio
 *      -- Mostrar la vista "private" con la información personalizada del usuario
 * - Sino
 *   - Petición Inicial
 *     -- Mostrar la vista "formlogin" de petición de credenciales para iniciar una sesión con la aplicación.
 *   - Proceso Formulario Login
 *     -- Leer los valores del formulario (nombre de usuasio y contraseña)
 *     -- Si los credenciales son correctos
 *           -- mostrar la vista "private" con información personaizada
 *        sino
 *           -- mostrar la vista "formlogin" con un mensaje de error de validación
 *   - En cualquier otro caso
 *     -- Mostrar la vista de login
 *
 *
 *
 */

require "vendor/autoload.php";

use eftec\bladeone;
use Dotenv\Dotenv;
use App\BD;
use App\Auth;
use App\Usuario;
use App\Poker;

$auth = Auth::getAuth();

$auth->init();
 

$views = __DIR__ . '/vistas';
$cache = __DIR__ . '/cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new bladeone\BladeOne($views, $cache);

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
    echo $blade->run("cnxbderror", compact('error'));
    die;
}


// Si el usuario ya está validado
if ($auth->check()) {
    // Si es una petición de cierre de sesión
    if (isset($_REQUEST['botonpetlogout'])) {
        // destruyo la sesión
        $auth->logout();
        // Redirijo al cliente a la vista del formulario de login
        echo $blade->run("formlogin");
        die;
    } elseif (isset($_REQUEST['botonvolverajugar'])) {
        $poker = $_SESSION['poker'];
        $poker->reset();
        $ganador = $poker->ganador();
        $victoria = is_a($ganador, '\App\Usuario');
        echo $blade->run("juego", compact('poker', 'victoria'));
        die;
    }
   
    //En otro caso
    else {
        // Redirijo al cliente a la vista de contenido
        $poker = $_SESSION['poker'];
        $ganador = $poker->ganador();
        $victoria = is_a($ganador, '\App\Usuario');
        echo $blade->run("juego", compact('poker', 'victoria'));
        die;
    }

    // Si se está solicitando el formulario de login
} elseif ((empty($_REQUEST)) || isset($_REQUEST['botonpetlogin'])) {
    echo $blade->run("formlogin");
    die;

// Si se está enviando el formulario de login con los datos
} elseif (isset($_REQUEST['botonpetproclogin'])) {
    $errores = [];
    $identificador = trim(filter_input(INPUT_POST, 'identificador', FILTER_SANITIZE_STRING));
    $clave = trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING));
    if (!($identificador && $clave)) {
        if (!$identificador) {
            $errores['identificador'] = "El valor del identificador es obligatorio";
        }
    
        if (!$clave) {
            $errores['clave'] = "El valor de la clave es obligatorio";
        }
    }
    else {
        if (!filter_var ($identificador, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^\w{3,25}$/"]])) {
            $errores['identificador'] = "El formato del identificador no es válido";
        }
        if (!filter_var ($clave, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^\d{8}/"]])) {
            $errores['clave'] = "El formato de la clave no es válido";
        }
    }
    if ($errores) {
        echo $blade->run("formlogin", compact('errores', 'identificador', 'clave'));
        die;
    }

    $usuario = Usuario::recuperaUsuarioPorCredencial($bd, $identificador, $clave);
    if ($usuario) {
        $auth->login($usuario);
        // Redirijo al cliente a la vista de contenido
        $poker = new Poker($usuario);
        $ganador = $poker->ganador();
        $victoria = is_a($ganador, '\App\Usuario');
        $_SESSION['poker'] = $poker;
        echo $blade->run("juego", compact('poker', 'victoria'));
        die;
    }

    // Si los credenciales son incorrectos
    else {
        // Establezco un mensaje de error para la
        $error = true;
        // Redirijo al cliente a la vista del formulario de login
        echo $blade->run("formlogin", compact('error'));
        die;
    }
}
?>
 