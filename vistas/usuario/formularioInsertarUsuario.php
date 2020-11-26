<script>
	function comprobarPasswd(){

		psswd1 = document.getElementbyId("psswd1").value;
		psswd2 = document.getElementbyId("psswd2").value;
		if(psswd1 != psswd2){
			document.getElementById('mensajeUsuario').innerHTML = "Las contraseñas deben de ser iguales";
			break;
		}
	}
</script>


<?php

	// Comprobamos si hay una sesion iniciada o no
		echo "<h1>Alta usuario</h1>";

		// Creamos el formulario con los campos del libro
		echo "<form action = 'index.php' method = 'POST' enctype='multipart/form-data'>
				E-mail:<input type='email' name='email'><br>
				Contraseña:<input type='password' name='password' id='psswd1'><br>
				Comprobar Contraseña:<input type='password' id='psswd2'><span id='mensajeUsuario'></span><br>
				Nombre:<input type='text' name='nombre'><br>
				Primer Apellido:<input type='text' name='apellido1'><br>
				Segundo Apellido:<input type='text' name='apellido2'><br>
				DNI:<input type='text' name='dni'><br>
				Imagen:<input type='file' name='imagen'><br>
				Tipo:<select name='tipo'>
						<option value='user' selected >Usuario</option>
						<option value='admin'>Admin</option>
					</select><br><br>";

		// Finalizamos el formulario
		echo "  <input type='hidden' name='action' value='insertarUsuario' onclick='comprobarPasswd()'>
				<input type='submit'>
			</form>";
		echo "<p><a href='index.php?action=mostrarUsuarios'>Volver</a></p>";