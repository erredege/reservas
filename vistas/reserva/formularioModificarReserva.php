<?php

$reserva = $data['reserva'][0];

echo "<h1>Modificar Reserva</h1>";
echo "<form action = 'index.php' method = 'POST'>
        <input type='hidden' name='id' value='$reserva->id'>
        Fecha:<input type='date' name='fecha' value='$reserva->fecha'><br>
        Hora:<input type='int' name='hora' value='$reserva->hora'><br>
        Precio:<input type='int' name='precio' value='$reserva->precio'>€ por hora<br>";
    echo "<input type='hidden' name='action' value='modificarReserva'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarReservas'>Volver</a></p>";
?>