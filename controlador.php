<?php
	include_once("vista.php");
	include_once("modelos/usuario.php");
	//include_once("modelos/incidencia.php");
	include_once("modelos/seguridad.php");

	// Creamos los objetos vista y modelos
 
 
    class Controlador {
 
        private $vista, $usuario;

        public function __construct() {
            $this->vista = new Vista();
            $this->usuario = new Usuario();
			$this->seguridad = new Seguridad();
        }

        public function mostrarFormularioLogin() {
			$this->vista->mostrar("usuario/formularioLogin");
        }
 
        public function procesarLogin() {
			$email = $_REQUEST["email"];
			$password = $_REQUEST["password"];

			$usuario = $this->usuario->buscarUsuario($email, $password);
			
			if ($usuario) {
				$this->seguridad->abrirSesion($usuario);
				//$this->mostrarListaIncidencias();
				$this->mostrarUsuarios();
			} 
			else {
				// Error al iniciar la sesion
				$data['msjError'] = "Nombre de usuario o contraseña incorrectos";
				$this->vista->mostrar("usuario/formularioLogin", $data);
			}
        }

		public function cerrarSesion() {

			$this->seguridad->cerrarSesion();
			$data['msjInfo'] = "Sesión cerrada correctamente";
			$this->vista->mostrar("usuario/formularioLogin", $data);
        }
			
			// --------------------------------- MOSTRAR LISTA DE INCIDENCIAS ----------------------------------------

        public function mostrarListaIncidencias() {
			$idUsuario = $_SESSION["idUsuario"];
			$data['listaIncidencias'] = $this->incidencia->getAll();
			$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
        }

			// --------------------------------- FORMULARIO INSERTAR INCIDENCIAS ----------------------------------------

        public function formularioInsertarIncidencia() {
			if ($this->seguridad->haySesionIniciada()) {
				$this->vista->mostrar('incidencia/formularioInsertarIncidencia');
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
        }
		

			// --------------------------------- INSERTAR INCIDENCIAS ----------------------------------------

        public function insertarIncidencia() {
				
			if ($this->seguridad->haySesionIniciada()) {
				// Vamos a procesar el formulario de alta de libros
				// Primero, recuperamos todos los datos del formulario
				// Ahora insertamos el libro en la BD
				$result = $this->incidencia->insert($fecha, $lugar, $equipo, $observaciones, $estado, $descripcion);

				// Lanzamos el INSERT contra la BD.
				if ($result == 1) {
					// Tenemos que averiguar que idUsuario se ha asignado a la incidencia que acabamos de insertar
					$ultimoId = $this->incidencia->getLastId();
					$data['msjInfo'] = "Incidencia insertado con exito";
				} else {
					// Si la insercion de la incidencia ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar la incidencia. Por favor, intentelo mas tarde.";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);

			}else {
				$this->seguridad->errorAccesoNoPermitido();
			}	
		}

		// --------------------------------- BORRAR INCIDENCIAS ----------------------------------------

        public function borrarIncidencia() {
			if ($this->seguridad->haySesionIniciada()) {

				$idIncidencia = $_REQUEST["idIncidencia"];
				$result = $this->incidencia->delete($idIncidencia);
				if ($result == 0) {
					$data['msjError'] = "Ha ocurrido un error al borrar esa incidencia. Por favor, intentelo de nuevo";
				} else {
					$data['msjInfo'] = "Incidencia borrada con exito";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}

		}

		// --------------------Elimina una incidencia de la base de datos (petición por ajax)----------------------------

	public function borrarIncidenciaAjax(){

		if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el id de la incidencia
			$idIncidencia = $_REQUEST["idIncidencia"];
			// Eliminamos la incidencia de la BD
			$result = $this->incidencia->delete($idIncidencia);
			if ($result == 0) {
				// Error al borrar. Enviamos el código -1 al JS
				echo "-1";
			}
			else {
				// Borrado con éxito. Enviamos el id del libro a JS
				echo $idIncidencia;
			}
		} else {
			echo "-1";
		}
	}

		// --------------------------------- FORMULARIO MODIFICAR INCIDENCIAS ----------------------------------------

		public function formularioModificarIncidencia() {
			if ($this->seguridad->haySesionIniciada()) {

				$idUsuario = $_SESSION["idUsuario"];
				$idIncidencia = $_REQUEST["idIncidencia"];
				$data['incidencia'] = $this->incidencia->get($idIncidencia);
				$this->vista->mostrar('incidencia/formularioModificarIncidencia', $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
		}

		// --------------------------------- MODIFICAR INCIDENCIAS ----------------------------------------

		public function modificarIncidencia() {

			if ($this->seguridad->haySesionIniciada()) {

				// Vamos a procesar el formulario de modificaci�n de libros
				// Primero, recuperamos todos los datos del formulario
				$idIncidencia = $_REQUEST["idIncidencia"];
				$fecha = $_REQUEST["fecha"];
				$lugar = $_REQUEST["lugar"];
				$equipo = $_REQUEST["equipo"];
				$observaciones = $_REQUEST["observaciones"];
				$estado = $_REQUEST["estado"];
				$descripcion = $_REQUEST["descripcion"];

				//lanzamos la consulta pa la bd
				$result = $this->incidencia->update($idIncidencia, $fecha, $lugar, $equipo, $observaciones, $estado, $descripcion);
				
				if ($result == 1) {
				// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
					$data['msjInfo'] = "Incidencia actualizada con éxito";
				}else {
					$data['msjError'] = "Error al actualizar la incidencia";
				}
				$data['listaIncidencias'] = $this->incidencia->getAll();
				$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
		}

		// --------------------------------- BUSCAR INCIDENCIAS ----------------------------------------

        public function buscarIncidencias() {
			// Recuperamos el texto de b�squeda de la variable de formulario
			$textoBusqueda = $_REQUEST["textoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de incidencas
			$data['listaIncidencias'] = $this->incidencia->busquedaAproximada($textoBusqueda);
			$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
			$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
		}

		//---------------------------------MOSTRAR LISTA USUARIOS ------------------------------------

		public function mostrarUsuarios() {
			$data['listaUsuarios'] = $this->usuario->getAll();
			$this->vista->mostrar("usuario/mostrarUsuarios", $data);
        }


		// --------------------------------- INSERTAR USUARIO ----------------------------------------

		 public function formularioInsertarUsuario() {
			if ($this->seguridad->haySesionIniciada()) {
				$this->vista->mostrar('usuario/formularioInsertarUsuario');
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
        }
		

			// --------------------------------- INSERTAR INCIDENCIAS ----------------------------------------

        public function insertarUsuario() {
			
			if ($this->seguridad->haySesionIniciada()) {
				// Vamos a procesar el formulario de alta de usuario
				// Primero, recuperamos todos los datos del formulario
				// Ahora insertamos el usuario en la BD
				$result = $this->usuario->insert();

				// Lanzamos el INSERT contra la BD.
				if ($result == 1) {
					// Tenemos que averiguar que idusuario se ha asignado al usuario que acabamos de insertar
					$ultimoId = $this->usuario->getLastId();
					$data['msjInfo'] = "Usuario insertado con exito";
				} else {
					// Si la insercion del usuario ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar el usuario. Por favor, intentelo mas tarde.";
				}
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
				
		}

		//---------------------------------- BORRAR USUARIO ---------------------------------

		public function borrarUsuario() {
			if ($this->seguridad->haySesionIniciada()) {
				$idUsuario = $_REQUEST["idUsuario"];
				$result = $this->usuario->delete($idUsuario);
				if ($result == 0) {
					$data['msjError'] = "Ha ocurrido un error al borrar ese usuario. Por favor, intentelo de nuevo";
				} else {
					$data['msjInfo'] = "Usuario borrado con exito";
				}
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}

		}

		// --------------------Elimina una incidencia de la base de datos (petición por ajax)----------------------------

	public function borrarUsuarioAjax(){

		if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el id de la incidencia
			$id = $_REQUEST["id"];
			// Eliminamos la incidencia de la BD
			$result = $this->usuario->delete($id);
			if ($result == 0) {
				// Error al borrar. Enviamos el código -1 al JS
				echo "-1";
			}
			else {
				// Borrado con éxito. Enviamos el id del libro a JS
				echo $id;
			}
		} else {
			echo "-1";
		}
	}

		// --------------------------------- FORMULARIO MODIFICAR USUARIOS ----------------------------------------

		public function formularioModificarUsuario() {
			if ($this->seguridad->haySesionIniciada()) {

				$idUsuario = $_REQUEST["idUsuario"];
				$data['usuario'] = $this->usuario->get($idUsuario);
				$this->vista->mostrar('usuario/formularioModificarUsuario', $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
		}

		// --------------------------------- MODIFICAR INCIDENCIAS ----------------------------------------

		public function modificarUsuario() {

			if ($this->seguridad->haySesionIniciada()) {

				//lanzamos la consulta pa la bd
				$result = $this->usuario->update();
				
				if ($result == 1) {
				// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
					$data['msjInfo'] = "Usuario actualizado con éxito";
				}else {
					$data['msjError'] = "Error al actualizar el usuario";
				}
				$data['listaUsuarios'] = $this->usuario->getAll();
				$this->vista->mostrar("usuario/mostrarUsuarios", $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
		}

		// --------------------------------- BUSCAR USUARIOS ----------------------------------------

        public function buscarUsuarios() {
			// Recuperamos el texto de búsqueda de la variable de formulario
			$textoBusqueda = $_REQUEST["textoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de usuarios
			$data['listaUsuarios'] = $this->usuario->busquedaAproximada($textoBusqueda);
			$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
			$this->vista->mostrar("usuario/mostrarUsuarios", $data);
		}

		// ---------------------------------- CAMBIAR VALOR DE ORDENACION INCIDENCIAS--------------------------------

		public function tipoBusqueda(){
			// Recuperamos el texto de búsqueda de la variable de formulario
			$tipoBusqueda = $_REQUEST["tipoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de incidencias
			$data['listaIncidencias'] = $this->incidencia->getOrder($tipoBusqueda);
			$data['msjInfo'] = "Busquedas ordenadas por: \"$tipoBusqueda\"";
			$this->vista->mostrar("incidencia/mostrarListaIncidencias", $data);
		}

		// ---------------------------------- CAMBIAR VALOR DE ORDENACION USUARIOS--------------------------------

		public function tipoBusquedaUsuarios(){
			// Recuperamos el texto de búsqueda de la variable de formulario
			$tipoBusqueda = $_REQUEST["tipoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de incidencias
			$data['listaUsuarios'] = $this->usuario->getOrder($tipoBusqueda);
			$data['msjInfo'] = "Busquedas ordenadas por: \"$tipoBusqueda\"";
			$this->vista->mostrar("usuario/mostrarusuarios", $data);
		}

		// ----------------------------------- COMPROBAR NOMBRE DE USUARIO -------------------------------------------

		public function comprobarNombreUsuario() {
			$nombre = $_REQUEST["nombre"];
			$result = $this->usuario->existeNombre($nombre);
			echo $result;
		}
    }
