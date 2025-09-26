<?php
    /*  Ejercicio 6. Mostrar una tabla de HTML con las tablas de multiplicar del 1 al 10.
    */
    echo "<h1>MI PRIMER PROYECTO EN PHP</h1>";
    echo '<table border="1" style="border-collapse: collapse;">';
    // CAPÇALERA
    echo '<tr><th style="background-color: #ffeaa7;" width="100px">Operadors</th>';
    // Bucle per posar els numeros de l'1 al 10 a la capçalera
    for ($i=1; $i <= 10; $i++) { 
        echo '<th style="background-color: #ffeaa7;" width="50px">'.$i.'</th>';
    }
    echo '</tr>';

    // FILES amb els VALORS (afegint sempre a la primera columna el numero multiplicador de la fila)
    for ($a=1; $a <= 10; $a++) {
        echo '<tr>';
        echo "<td style='font-weight: bold; background-color: #ffeaa7; text-align:center;' > $a </td>";
        for ($b=1; $b <= 10; $b++) {
            echo "<td> ".$a*$b." </td>";
        }
        echo '</tr>';
    }
    echo '</table>';

?>