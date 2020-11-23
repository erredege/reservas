<script>
	// **** Petición y respuesta AJAX con jQuery ****

	$(document).ready(function() {
		$(".btnBorrar").click(function() {
			$.get("index.php?action=borrarInstalacionAjax&id=" + this.id, null, function(idBorrada) {
	
				if (idBorrada == -1) {
					$('#msjError').html("Ha ocurrido un error al borrar la instalacion");
				}
				else {
					$('#msjInfo').html("Instalacion borrada con éxito");
					$('#instalacion' + idBorrada).remove();
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
		<a href='index.php?action=/*TODO*/'> Instalaciones </a></h1></p>";
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
				<input type='text' name='textoBusqueda' placeholder='nombre, descripcion o precio' size='30'>
				<input type='submit' value='Buscar'>
			</form><br>";
	}

	if (isset($_SESSION["id"])) {
		echo "<form action = 'index.php' method = 'get'>
			Ordenar por: 
			<select name='tipoBusqueda'>
				<option value='nombre'>Nombre</option>
				<option value='descripcion'>Descripcion</option>
				<option value='precio'>Precio</option>
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
				echo "<td>Descripcion</td>";
				echo "<td>Precio</td>";
				if (isset($_SESSION["id"])){
					echo "<td colspan='2'>Opciones</td>";
				}
            echo "</tr>";
            
			foreach($data['listaInstalaciones'] as $instalaciones) {
				echo "<tr id='usuario".$instalaciones->id."'>";
					echo "<td>".$instalaciones->imagen."</td>";
					echo "<td>".$instalaciones->nombre."</td>";
					echo "<td>".$instalaciones->descripcion."</td>";
					echo "<td>".$instalaciones->precio."</td>";
					if (isset($_SESSION["id"])){
						echo "<td><a href='index.php?action=formularioModificarInstalacion&id=".$instalaciones->id."'>Modificar</a></td>";
						//echo "<td><a href='index.php?action=borrarUsuario&idUsuario=".$usuarios->id."'>Borrar</a></td>";
						echo "<td><a href='#' class='btnBorrar' id='".$instalaciones->id."'>Borrar por Ajax/jQuery</a></td>";
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
		echo "<p><a href='index.php?action=formularioInsertarInstalacion'>Nuevo</a></p>";
	}

	// Enlace a "Iniciar sesion" o "Cerrar sesion"
	if (isset($_SESSION["id"])) {
		echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesion</a></p>";
	}
	else {
		echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesion</a></p>";
	}