<script>
	// **** Petición y respuesta AJAX con jQuery ****

	$(document).ready(function() {
		$(".btnBorrar").click(function() {
			$.get("index.php?action=borrarReservaAjax&id=" + this.id, null, function(idBorrada) {
	
				if (idBorrada == -1) {
					$('#msjError').html("Ha ocurrido un error al borrar la reserva");
				}
				else {
					$('#msjInfo').html("Reserva borrada con éxito");
					$('#reserva' + idBorrada).remove();
				}
			});
		});
	});
</script>

<?php

	//TODO MENU 
	if($_SESSION['tipo'] ==  "admin"){
		echo "<p><h1><a href='index.php?action=mostrarReservas'>Reservas</a> | 
		<a href='index.php?action=mostrarUsuarios'>Usuarios</a> | 
		<a href='index.php?action=mostrarInstalaciones'>Instalaciones</a></h1></p>";
	}else{
		echo "<p><a href='index.php?action=mostrarInstalaciones'><h1>Registro de Instalaciones</h1></a></p>";
	}
	// Mostramos info del usuario logueado (si hay alguno)
	if ($this->seguridad->haySesionIniciada()) {
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
	if ($this->seguridad->haySesionIniciada()){
		echo "<form action='index.php'>
				<input type='hidden' name='action' value='buscarReserva'>
				BUSCAR POR:
				<input type='text' name='textoBusqueda' placeholder='fecha, hora o precio' size='30'>
				<input type='submit' value='Buscar'>
			</form><br>";
	}

	if ($this->seguridad->haySesionIniciada()) {
		echo "<form action = 'index.php' method = 'get'>
			Ordenar por: 
			<select name='tipoBusqueda'>
				<option value='fecha'>Fecha</option>
				<option value='hora'>Hora</option>
				<option value='precio'>Precio</option>
			</select>
			<input type='hidden' name='action' value='tipoBusquedaReserva'>
			<input type='submit' value='Ordenar'>";
	}
	echo"<br>";
	var_dump($data);

	if (count($data['listaReservas']) > 0) {
		// Ahora, la tabla con los datos de los libros
		echo "<table border ='1'>";
			echo "<tr>";
				echo "<td>Lunes</td>";
				echo "<td>Martes</td>";
				echo "<td>Miercoles</td>";
                echo "<td>Jueves</td>";
                echo "<td>Viernes</td>";
                echo "<td>Sabado</td>";
                echo "<td>Domingo</td>";
			echo "</tr>";
			echo "<tr>";
            $cont=01;
            while ($cont <= 31) {
				echo "<td>";
				echo "$cont <br>";
				foreach($data['listaReservas'] as $reservas) {
					if($data['dia'] == $cont){
						echo "<input id='instalacion".$reservas->id."' type='hidden'>";
						echo "fecha: ".$reservas->fecha."<br>";
						echo "hora: ".$reservas->hora."<br>";
						echo "precio: ".$reservas->precio."€/hora <br>";
						if (isset($_SESSION["id"])){
							echo "<a href='index.php?action=formularioModificarReserva&id=".$reservas->id."'>Modificar</a><br>";
							echo "<a href='#' class='btnBorrar' id='".$reservas->id."'>Borrar</a><br>";
						} 
						echo"-----------------------<br>";
					}

				}
				// El bot�n "Nueva reserva" solo se muestra si hay una sesi�n iniciada
				if ($this->seguridad->haySesionIniciada()) {
					echo "<p><a href='index.php?action=formularioInsertarReserva'>Nuevo</a></p>";
				}
				echo "</td>";
                if($cont%7 == 0){echo "</tr><tr>";}
                $cont++;
            }
		
		echo "</table>";
	} 
	else {
		// La consulta no contiene registros
		echo "No se encontraron datos";
	}

	// Enlace a "Iniciar sesion" o "Cerrar sesion"
	if ($this->seguridad->haySesionIniciada()) {
		echo "<p><a href='index.php?action=cerrarSesion'>Cerrar sesion</a></p>";
	}
	else {
		echo "<p><a href='index.php?action=mostrarFormularioLogin'>Iniciar sesion</a></p>";
	}