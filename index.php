<?php

/*
 * A continuación se detallan los mensajes que le pueden llegar
 * al controlador y la lógica de proceso para cada uno de ellos.
 *
 * - Si la petición proviene de un usuario ya validado
 *   - Proceso Cerrar Sesión
 *      -- Eliminar la sesión PHP
 *      -- Mostrar la vista "formlogin" con el formulario de login
 *   - Petición de formulario de Perfil
 *      -- Mostrar la vista perfil con el formulario de perfil del usuario
 *   - Petición de Proceso de datos de perfil
 *      -- Recuperar el usuario de la sesión
 *      -- Modificar sus propiedades con los campos del formulario
 *      -- Si el nombre del pintor favorito ha cambiado
 *           -- Recuperar el objeto correspondiente al nuevo pintor
 *           -- Relacionar el usuario con el nuevo pintor
 *      -- Pedir al usuario que persista sus cambios
 *      -- Pedir al usuario un cuadro aleatorio
 *      -- Mostrar la vista "private" con la información personalizada del usuario
 *   - Petición de baja
 *      -- Recuperar el usuario que tiene la sesión abierta
 *      -- Pedir al usuario que se borre
 *      -- Cerrar la sesión
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
 *   - Petición de Registro
 *     -- Recuperar la lista de pintores
 *     -- Mostrar el formulario de registro de usuario
 *   - Proceso de formulario de registro
 *     -- Leer los datos del formulario de registro
 *     -- Construyo un usuario para persistir
 *     -- Pido al usuario que se persista
 *     -- Inicio una sesión en nombre del usuario
 *     -- Pido al usuario un cuadro aleatorio
 *     -- Mostrar la vista "private" con la información personalizada del usuario
 *   - En cualquier otro caso
 *     -- Mostrar la vista de login
 *
 *
 *
 */

require "vendor/autoload.php";
require "validacion/patrones.php";


use eftec\bladeone;
use Dotenv\Dotenv;
use Valitron\Validator;
use App\BD;
use App\Auth;
use App\Usuario;


$auth = Auth::getAuth();

$auth->init();

// Reglas de validación para validar el formulario en el servidor
 

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

$modoVal = $_ENV['MODO_VAL'];

// Si el usuario ya está validado
if ($auth->check()) {
    // Si es una petición de cierre de sesión
    if (isset($_REQUEST['botonpetlogout'])) {
        // destruyo la sesión
        $auth->logout();
        // Redirijo al cliente a la vista del formulario de login
        $patrones = array_intersect_key(PATRONES, array_fill_keys(['identificador', 'clave'], ""));
        echo $blade->run("formlogin", compact('patrones', 'modoVal'));
        die;
    } elseif (isset($_REQUEST['botonpetperfil'])) {
        $usuario = $auth->loggedUsuario();
        $pintores = Pintor::recuperaPintores($bd);
        // Muestro la vista de formulario de perfil
        $campos = ['identificador', 'nombre', 'apellidos', 'email', 'ocupacion', 'clave'];
        $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
        echo $blade->run("perfil", compact('patrones', 'usuario', 'pintores', 'modoVal'));
        die;
    } elseif (isset($_POST['botonpetprocperfil'])) {
        $usuario = $auth->loggedUsuario();
        $identificador = trim(filter_input(INPUT_POST, 'identificador', FILTER_SANITIZE_STRING));
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
        $apellidos = trim(filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
        $ocupacion = trim(filter_input(INPUT_POST, 'ocupacion', FILTER_SANITIZE_STRING));
        $clave = trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING));
        $genero = filter_input(INPUT_POST, 'genero', FILTER_DEFAULT);
        $campos = ['identificador', 'nombre', 'apellidos', 'email', 'ocupacion', 'clave'];
        $valores = [$identificador, $nombre, $apellidos, $email, $ocupacion, $clave];
        $pintor = $_POST['pintor'];
        $datos = array_combine($campos, $valores);
        $reglas = array_intersect_key(REGLAS, array_fill_keys($campos, ""));
        $v = new Validator($datos);
        $v->mapFieldsRules($reglas);
        $v->validate();
        $errores = $v->errors();
        if (!empty($errores)) {
            $pintores = Pintor::recuperaPintores($bd);
            $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
            echo $blade->run("perfil", compact('patrones', 'datos', 'errores', 'usuario', 'pintores', 'modoVal'));
            die;
        }
        $usuarioClone = clone $usuario;
        $usuario->setIdentificador($identificador);
        $usuario->setNombre($nombre);
        $usuario->setApellidos($apellidos);
        $usuario->setClave($clave);
        $usuario->setEmail($email);
        $usuario->setOcupacion($ocupacion);
        $usuario->setGenero($genero);
        $pintor = Pintor::recuperaPintorPorNombre($bd, $pintor);
        $usuario->setPintor($pintor);
        try {
            $usuario->persiste($bd);
        } catch (PDOException $e) {
            $usuario = $usuarioClone;
            $error = true;
            $pintores = Pintor::recuperaPintores($bd);
            $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
            echo $blade->run("perfil", compact('patrones', 'datos', 'errores', 'usuario', 'pintores', 'modoVal'));
            die();
        }
        $cuadro = $usuario->getPintor()->getCuadroAleatorio();
        try {
            $soapClient = new SimpleSoapClient('wsdl', LOCATION_WSDL);
            $location = $soapClient->GetLocationRawOutput(['sIPAddress' => IPs[array_rand(IPs)]]);
            $geolocation = $location->GetLocationRawOutputResult->geolocation_data;
        } catch (Exception $exception) {
            die('Error: ' . $exception->getMessage());
        }
        echo $blade->run("private", compact('usuario', 'cuadro', 'geolocation'));
        die;
    } elseif (isset($_REQUEST['botonpetbaja'])) {
        $usuario = $auth->loggedUsuario();
        $usuario->elimina($bd);
        $auth->logout();
        $campos = ['identificador', 'clave'];
        // Redirijo al cliente a la vista del formulario de login
        $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
        echo $blade->run("formlogin", compact('patrones'));
        die;
    }
    //En otro caso
    else {
        // Redirijo al cliente a la vista de contenido
        $usuario = $auth->loggedUsuario();
        $cuadro = $usuario->getPintor()->getCuadroAleatorio();
        try {
            $soapClient = new SimpleSoapClient('wsdl', LOCATION_WSDL);
            $location = $soapClient->GetLocationRawOutput(['sIPAddress' => IPs[array_rand(IPs)]]);
            $geolocation = $location->GetLocationRawOutputResult->geolocation_data;
        } catch (Exception $exception) {
            die('Error: ' . $exception->getMessage());
        }
        echo $blade->run("private", compact('usuario', 'cuadro', 'geolocation'));
        die;
    }

    // Si se está solicitando el formulario de login
} elseif ((empty($_REQUEST)) || isset($_REQUEST['botonpetlogin'])) {
    $campos = ['identificador', 'clave'];
    // Redirijo al cliente a la vista del formulario de login
    $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
    echo $blade->run("formlogin", compact('patrones', 'modoVal'));
    die;

// Si se está enviando el formulario de login con los datos
} elseif (isset($_REQUEST['botonpetproclogin'])) {
    $identificador = trim(filter_input(INPUT_POST, 'identificador', FILTER_SANITIZE_STRING));
    $clave = trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING));
    $campos = ['identificador', 'clave'];
    $datos = array_combine($campos, [$identificador, $clave]);
    $reglas = array_intersect_key(REGLAS, array_fill_keys($campos, ""));
    $v = new Validator($datos);
    $v->mapFieldsRules($reglas);
    $v->validate();
    $errores = $v->errors();

    if (!empty($errores)) {
        $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
        echo $blade->run("formlogin", compact('patrones', 'datos', 'errores', 'modoVal'));
        die;
    }
    $usuario = Usuario::recuperaUsuarioPorCredencial($bd, $identificador, $clave);
    if ($usuario) {
        $auth->login($usuario);
        // Redirijo al cliente a la vista de contenido

        $cuadro = $usuario->getPintor()->getCuadroAleatorio();

        try {
            $soapClient = new SimpleSoapClient('wsdl', LOCATION_WSDL);
            $location = $soapClient->GetLocationRawOutput(['sIPAddress' => IPs[array_rand(IPs)]]);
            $geolocation = $location->GetLocationRawOutputResult->geolocation_data;
        } catch (Exception $exception) {
            die('Error: ' . $exception->getMessage());
        }

        echo $blade->run("private", compact('usuario', 'cuadro', 'error', 'geolocation'));
        die;
    }

    // Si los credenciales son incorrectos
    else {
        // Establezco un mensaje de error para la
        $error = true;
        // Redirijo al cliente a la vista del formulario de login
        $patrones = array_intersect_key(PATRONES, array_fill_keys(['identificador', 'clave'], ""));
        echo $blade->run("formlogin", compact('patrones', 'error', 'modoVal'));
        die;
    }
} elseif (isset($_REQUEST['botonpetregistro'])) {
    $pintores = Pintor::recuperaPintores($bd);
    $patrones = array_intersect_key(PATRONES, array_fill_keys(['identificador', 'clave'], ""));
    echo $blade->run("registro", compact('patrones', 'pintores', 'modoVal'));
    die;
} elseif (isset($_POST['botonpetprocregistro'])) {
    $identificador = trim(filter_input(INPUT_POST, 'identificador', FILTER_SANITIZE_STRING));
    $clave = trim(filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_STRING));
    $pintorNombre = $_POST['pintor'];
    $campos = ['identificador', 'clave'];
    $datos = array_combine($campos, [$identificador, $clave]);
    $reglas = array_intersect_key(REGLAS, array_fill_keys($campos, ""));
    $v = new Validator($datos);
    $v->mapFieldsRules($reglas);
    $v->validate();
    $errores = $v->errors();
    if (!empty($errores)) {
        $pintores = Pintor::recuperaPintores($bd);
        $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
        echo $blade->run("registro", compact('patrones', 'datos', 'errores', 'pintores', 'modoVal'));
        die;
    }
    $usuario = new Usuario($identificador, $clave);
    $usuario->setPintor(Pintor::recuperaPintorPorNombre($bd, $pintorNombre));
    try {
        $usuario->persiste($bd);
    } catch (PDOException $e) {
        $error = true;
        $pintores = Pintor::recuperaPintores($bd);
        $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
        echo $blade->run("registro", compact('patrones', 'datos', 'errores', 'modoVal'));
        die;
    }
    $auth->login($usuario);
    // Redirijo al cliente a la vista de contenido
    $cuadro = $usuario->getPintor()->getCuadroAleatorio();

    try {
        $soapClient = new SimpleSoapClient('wsdl', LOCATION_WSDL);
        $location = $soapClient->GetLocationRawOutput(['sIPAddress' => IPs[array_rand(IPs)]]);
        $geolocation = $location->GetLocationRawOutputResult->geolocation_data;
    } catch (Exception $exception) {
        die('Error: ' . $exception->getMessage());
    }
           
    echo $blade->run("private", compact('usuario', 'cuadro', 'geolocation'));
    die;
} else {
    $campos = ['identificador', 'clave'];
    // Redirijo al cliente a la vista del formulario de login
    $patrones = array_intersect_key(PATRONES, array_fill_keys($campos, ""));
    echo $blade->run("formlogin", compact('patrones'), 'modoVal');
    die;
}
?>
 