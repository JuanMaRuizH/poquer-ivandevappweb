# Póquer

Escribe una aplicación PHP que implemente un sencillo juego de póquer entre un jugador humano y la máquina. 

Los usuarios podrán iniciar sesión en la aplicación utilizando sus credenciales personales (nombre de usuario y contraseña). Para simplificar su implementación, partimos de la 
existencia de tres cuentas en la base de datos que deberemos crear previamente utilizando nuestro interfaz con la base de datos favorito. 
Las cuentas son: (reynaipes32/11112222, jackLOCO/45454545 y rePOKER/15051980).

La aplicación deberá validar los datos introducidos en el formulario de login en el cliente y el sevidor utilizando las siguientes reglas de formato:

* El nombre de usuario está compuestos por letras (mayúsculas y minúsculas) sin acentos y números, aunque su primera letra debe ser una minúscula. Su longitud está comprendida entre 3 y 10 caracteres.

* La contraseña es una cadena de 8 dígitos.

Tras autenticar al usuario la aplicación mostrará al usuario una vista con un mensaje de bienvenida personalizado con su nombre y un botón para iniciar una partida.

El transcurso de la partida será el siguiente, primero se le muestra al usuario su mano de 5 cartas y un botón para continuar la partida cuando haya visto las cartas que le han tocado.
A continuación, se le presenta una vista que le muestra las dos manos de cartas, la suya y la de la máquina, y el ganador de la partida.

El póker se juega con una baraja francesa con un conjunto de naipes o cartas, formado por 52 unidades repartidas en cuatro palos: corazones (hearts), diamantes (diamonds), tréboles (clubs) y picas (spades). Cada palo tiene el siguiente conjunto de cartas: As, 2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K. 

Las jugadas que se pueden obtener empezando por la de mayor valor hacia abajo son:

* Póquer: Cuatro cartas del mismo valor y una carta no emparejada. En caso de empate, gana el jugador con la carta más alta.

* Full: Tres cartas del mismo valor y un par de un mismo valor diferente al anterior. En caso de empate, gana el trío más alto.

* Color: Cinco cartas del mismo palo, no necesariamente consecutivas. En caso de empate, gana el jugador con la carta más alta.

* Escalera: Cinco cartas consecutivas no necesariamente del mismo palo. En caso de empate, gana la carta más alta.

* Trío: Tres cartas del mismo valor y dos cartas no emparejadas. En caso de empate, gana el jugador con la carta más alta, y si es necesario, la segunda carta no emparejada gana.

* Doble Par: Dos cartas del mismo valor, otras dos cartas del mismo valor diferente al anterior y una carta no emparejada. Si ambos jugadores tienen un doble par idéntico, la carta no emparejada más alta gana.

* Par: Dos cartas del mismo valor y tres cartas no emparejadas. En caso de empate, gana el jugador con la carta más alta, y si es necesario, la segunda o tercera carta no emparejada gana.

* Carta alta: Cualquier mano que no esté clasificada entre una de las categorías anteriores. En caso de empate, gana la carta más alta, como "carta al as".



