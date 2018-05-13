<?php

define("REGEXP_IDENTIFICADOR", "^\w{3,25}$");
define("REGEXP_IDENTIFICADOR_DESC", "El identificador tiene entre 3 y 25 caracteres sin tildes, incluyendo letras, números y guiones");

define("REGEXP_CLAVE", "^(?=.*\d).{4,8}");
define("REGEXP_CLAVE_DESC", "La clave tiene entre 4 y 8 caracteres sin tildes e incluye al menos un número");


$c = 'constant';
define(
    'REGLAS',
 ['identificador' => [['required', 'message' => 'Debe rellenar este campo'], ['regex', "/{$c('REGEXP_IDENTIFICADOR')}/", 'message' => REGEXP_IDENTIFICADOR_DESC]],
          'clave' => [['required', 'message' => 'Debe rellenar este campo'], ['regex', "/{$c('REGEXP_CLAVE')}/", 'message' => REGEXP_CLAVE_DESC]]
]
);

// Lista de patrones utilizados para validar el formulario en el cliente

define(
    'PATRONES',
 ['identificador' => ['regexp' => REGEXP_IDENTIFICADOR, 'mensaje' => REGEXP_IDENTIFICADOR_DESC],
 'clave' => ['regexp' => REGEXP_CLAVE, 'mensaje' => REGEXP_CLAVE_DESC]
]
);