# Póquer

Escribe una aplicación PHP que implemente un sencillo juego de póquer entre un jugador humano y la máquina. 

Los usuarios podrán iniciar sesión en la aplicación utilizando sus credenciales personales (nombre de usuario y contraseña). Para simplificar su implementación, partimos de la 
existencia de tres cuentas en la base de datos que deberemos crear previamente utilizando nuestro interfaz con la base de datos favorito. 
Las cuentas son: (reynaipes/11112222, jackLOCO/45454545 y rePOKER/15051980). Una vez iniciada la sesión los usuarios pueden finalizarla desde cualquier vista del juego.

La aplicación deberá validar los datos introducidos en el formulario de login utilizando las siguientes reglas de formato:

* El nombre de usuario está compuesto por letras (mayúsculas y minúsculas) sin acentos y números, aunque su primera letra debe ser una minúscula. Su longitud está comprendida entre 3 y 10 caracteres.

* La contraseña es una cadena de 8 dígitos.

El transcurso de la partida será el siguiente, primero se le muestra al usuario su mano de 5 cartas y un botón para continuar la partida cuando haya visto las cartas que le han tocado.
A continuación, se le presenta una vista que le muestra las dos manos de cartas, la suya y la de la máquina, y se le informa del ganador de la partida.
Cuando el usuario es autenticado por la aplicación se le mostrará directamente la primera mano de su primer juego.

El póker se juega con una baraja francesa con un conjunto de naipes o cartas, formado por 52 unidades repartidas en cuatro palos: corazones (hearts), diamantes (diamonds), tréboles (clubs) y picas (spades). 
Cada palo tiene el siguiente conjunto de cartas: A, K, Q, J, 10, 9, 8, 7, 6, 5, 4, 3 y 2 en orden decreciente de valor.

Las jugadas que se pueden obtener empezando por la de mayor valor hacia abajo son:

* Escalera Real: Está compuesta por as, rey, reina, jota y diez de un mismo palo.

* Escalera de color: Cinco cartas consecutivas del mismo palo. En caso de empate, gana la secuencia con la carta más alta.

* Póquer: Cuatro cartas del mismo valor y una carta no emparejada. En caso de empate, gana el jugador con la carta más alta.

* Full: Tres cartas del mismo valor y un par de un mismo valor diferente al anterior. En caso de empate, gana el trío más alto.

* Color: Cinco cartas del mismo palo, no necesariamente consecutivas. En caso de empate, gana el jugador con la carta más alta.

* Escalera: Cinco cartas consecutivas no necesariamente del mismo palo. En caso de empate, gana la carta más alta.

* Trío: Tres cartas del mismo valor y dos cartas no emparejadas. En caso de empate, gana el jugador con la carta más alta, y si es necesario, la segunda carta no emparejada gana.

* Doble Par: Dos cartas del mismo valor, otras dos cartas del mismo valor diferente al anterior y una carta no emparejada. Si ambos jugadores tienen un doble par idéntico, la carta no emparejada más alta gana.

* Par: Dos cartas del mismo valor y tres cartas no emparejadas. En caso de empate, gana el jugador con la carta más alta, y si es necesario, la segunda o tercera carta no emparejada gana.

* Carta alta: Cualquier mano que no esté clasificada entre una de las categorías anteriores. En caso de empate, gana la carta más alta.

Propuesta de algoritmo para obtener el valor de una mano de póquer:

Para comparar las cartas del jugador y la máquina se recomienda que se convierta cada mano de cartas a una cadena resumen. La comparación alfabética de las cadenas nos permitirá conocer el
ganador de la partida.
El formato de la cadena será el siguiente:
- Primera letra: Representa el tipo de jugada. Toma los valores de 0 a 9 en orden creciente de valor de jugada.
- Resto de letras: Dependiendo de la jugada se añadirá el valor de las cartas que sirva para desempatar.
Las cartas se representan por un único dígito hexadecimal: 2->2, 3->3, 4->4, 5->5, 6->6, 7->7, 8->8, 9->9, 10->A, J->B, Q->C, K->D, A->E.

Ejemplos de conversiones:

- Escalera Real: "9"
- Full Reyes y Damas: "6D"
- Doble Pareja 6 y 4 con un 7 sin emparejar: "2647"

Pistas de funciones útiles: 

- array_count_values es útil para obtener repeticiones de números en un array.
- ksort y krsort permite ordenar un array en base a el valor de la clave. El flag "SORT_STRING" trata las claves como cadenas.
- array_keys devuelve la lista de claves que indexan un mismo valor en el array.
- shuffle es útil para mezclar los elementos de un array de manera aleatoria.

  







