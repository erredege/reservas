<script>
	// **** Petición y respuesta AJAX con jQuery ****

	$(document).ready(function() {
		$(".btnBorrar").click(function() {
			$.get("index.php?action=borrarUsuarioAjax&id=" + this.id, null, function(idBorrada) {
	
				if (idBorrada == -1) {
					$('#msjError').html("Ha ocurrido un error al borrar el usuario");
				}
				else {
					$('#msjInfo').html("Usuario borrado con éxito");
					$('#usuario' + idBorrada).remove();
				}
			});
		});
	});
</script>

<?php

	//TODO MENU 
	if($_SESSION['tipo'] ==  "admin"){
		echo "<p><h1><a href='index.php?action=/*TODO*/'> Reservas </a> | 
		<a href='index.php?action=mostrarUsuarios'>Usuarios</a> | 
		<a href='index.php?action=mostrarInstalaciones'> Instalaciones </a></h1></p>";
	}else{
		echo "<p><a href='index.php?action=mostrarUsuarios'><h1>Registro de Usarios</h1></a></p>";
	}
	// Mostramos info del usuario logueado (si hay alguno)
	if (isset($_SESSION['id'])) {
		echo "<p>Sesion iniciada como, ".$_SESSION['nombre']."</p>";
	}
	// Mostramos mensaje de error o de informaci�n (si hay alguno)
	if (isset($data['msjError'])) {
		echo "<p style='color:red'>".$data['msjError']."</p>";
	}
	if (isset($data['msjInfo'])) {
		echo "<p style='color:blue'>".$data['msjInfo']."</p>";
	}
	
	// Primero, el formulario de busqueda
	if (isset($_SESSION['id'])){
		echo "<form action='index.php'>
				<input type='hidden' name='action' value='buscarUsuarios'>
				BUSCAR POR:
				<input type='text' name='textoBusqueda' placeholder='id, nombre, apellidos o tipo de usuario' size='30'>
				<input type='submit' value='Buscar'>
			</form><br>";
	}

	if (isset($_SESSION["id"])) {
		echo "<form action = 'index.php' method = 'get'>
			Ordenar por: 
			<select name='tipoBusqueda'>
				<option value='email'>e-mail</option>
				<option value='nombre'>nombre</option>
				<option value='apellido1'>1º apellido</option>
				<option value='apellido2'>2º apellido</option>
				<option value='tipo'>tipo</option>
				<option value='dni'>DNI</option>
			</select>
			<input type='hidden' name='action' value='tipoBusquedaUsuarios'>
			<input type='submit' value='Ordenar'>";
	}

	if (count($data['listaUsuarios']) > 0) {

		// Ahora, la tabla con los datos de los libros
		echo "<table border ='1'>";
			echo "<tr>";
				echo "<td>Imagen</td>";
				echo "<td>Nombre</td>";
				echo "<td colspan='2'>Apellidos</td>";
				echo "<td>E.mail</td>";
				echo "<td>Tipo</td>";
				echo "<td>DNI</td>";
				if (isset($_SESSION["id"])){
					echo "<td colspan='2'>Opciones</td>";
				}
            echo "</tr>";
            
			foreach($data['listaUsuarios'] as $usuarios) {
				echo "<tr id='usuario".$usuarios->id."'>";
					echo "<td>".$usuarios->imagen."</td>";
					echo "<td>".$usuarios->nombre."</td>";
					echo "<td>".$usuarios->apellido1."</td>";
					echo "<td>".$usuarios->apellido2."</td>";
					echo "<td>".$usuarios->email."</td>";
					echo "<td>".$usuarios->tipo."</td>";
					echo "<td>".$usuarios->dni."</td>";
					if (isset($_SESSION["id"])){
						echo "<td><a href='index.php?action=formularioModificarUsuario&id=".$usuarios->id."'>Modificar</a></td>";
						//echo "<td><a href='index.php?action=borrarUsuario&idUsuario=".$usuarios->id."'>Borrar</a></td>";
						echo "<td><a href='#' class='btnBorrar' id='".$usuarios->id."'>Borrar por Ajax/jQuery</a></td>";
					}
				echo "</tr>";
			}
		
		echo "</table>";
	} 
	else {
		// La consulta no contiene registros
		echo "No se encontraron datos";
	}

	// El bot�n "Nuevo libro" solo se muestra si hay una sesi�n iniciada
	if (isset($_SESSION["id"])) {
		echo "<p><a href='index.php?action=formularioInsertarUsuario'>Nuevo</a></p>";
	}

	// Enlace a "Iniciar sesion" o "Cerrar sesion"
	if (isset($_SESSION["id"])) {
		echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesion</a></p>";
	}
	else {
		echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesion</a></p>";
	}