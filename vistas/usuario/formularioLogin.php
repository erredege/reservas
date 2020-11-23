<script>

	function ejecutar_ajax() {
		peticion_http = new XMLHttpRequest();
		peticion_http.onreadystatechange = procesa_respuesta;
		email = document.getElementById("emailUsuario").value;
		peticion_http.open('GET', 'http://localhost/20-21/reservas/index.php?action=comprobaremailUsuario&emailUsuario=' + email, true);
		peticion_http.send(null);
	}	

	function procesa_respuesta() {
		if(peticion_http.readyState == 4) {
			if(peticion_http.status == 200) {
				if (peticion_http.responseText == "0"){
					document.getElementById('mensajeUsuario').innerHTML = "Error, ese usuario no existe";
				}
				if (peticion_http.responseText == "1"){
					document.getElementById('mensajeUsuario').innerHTML = "Usuario OK";
				}
			}
		}
	}	
</script>



<h1>Iniciar sesion</h1>

<?php
	if (isset($data['msjError'])) {
		echo "<p style='color:red'>".$data['msjError']."</p>";
	}
	if (isset($data['msjInfo'])) {
		echo "<p style='color:blue'>".$data['msjInfo']."</p>";
	}
?>

<form action='index.php'>
	E-mail:<input type='email' name='email' id='emailUsuario' onBlur='ejecutar_ajax()'>
	<span id='mensajeUsuario'></span><br>
	Clave:<input type='password' name='password'><br>
	<input type='hidden' name='action' value='procesarLogin'>
	<input type='submit'>
</form>