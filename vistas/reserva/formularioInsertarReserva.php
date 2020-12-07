<?php

	// Comprobamos si hay una sesion iniciada o no
		echo "<h1>Alta reserva</h1>";

		// Creamos el formulario con los campos del libro
		echo "<form action = 'index.php' method = 'POST'>
				Fecha:<input type='date' name='fecha'><br>
				Hora:<input type='int' name='hora'><br>
				Precio:<input type='int' name='precio'>€ por hora<br>";

		// Finalizamos el formulario
		echo "  <input type='hidden' name='action' value='insertarReserva'>
				<input type='submit'>
			</form>";
		echo "<p><a href='index.php?action=mostrarReservas'>Volver</a></p>";