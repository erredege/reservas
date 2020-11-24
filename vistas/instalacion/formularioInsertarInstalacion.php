<?php

	// Comprobamos si hay una sesion iniciada o no
		echo "<h1>Alta instalacion</h1>";

		// Creamos el formulario con los campos del libro
		echo "<form action = 'index.php' method = 'get'>
				Nombre:<input type='text' name='nombre'><br>
				Descripcion:<input type='text' name='descripcion'><br>
				Precio:<input type='int' name='precio'>€ por hora<br>
				Imagen:<input type='file' name='imagen'><br>";

		// Finalizamos el formulario
		echo "  <input type='hidden' name='action' value='insertarInstalacion'>
				<input type='submit'>
			</form>";
		echo "<p><a href='index.php?action=mostrarInstalacion'>Volver</a></p>";