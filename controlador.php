<?php
	include_once("vista.php");
	include_once("modelos/seguridad.php");
	include_once("modelos/usuario.php");
	include_once("modelos/instalacion.php");

	// Creamos los objetos vista y modelos
 
 
    class Controlador {
 
        private $vista, $usuario;

        public function __construct() {
            $this->vista = new Vista();
			$this->seguridad = new Seguridad();
			$this->usuario = new Usuario();
			$this->instalacion = new Instalacion();
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
			
			// --------------------------------- MOSTRAR LISTA DE Instalaciones ----------------------------------------

        public function mostrarInstalaciones() {
			$id = $_SESSION["id"];
			$data['listaInstalaciones'] = $this->instalacion->getAll();
			$this->vista->mostrar("instalacion/mostrarInstalaciones", $data);
        }

			// --------------------------------- FORMULARIO INSERTAR Instalaciones ----------------------------------------

        public function formularioInsertarInstalacion() {
			if ($this->seguridad->haySesionIniciada()) {
				$this->vista->mostrar('instalacion/formularioInsertarInstalacion');
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
        }
		

			// --------------------------------- INSERTAR Instalaciones ----------------------------------------

        public function insertarInstalacion() {
				
			if ($this->seguridad->haySesionIniciada()) {
				// Vamos a procesar el formulario de alta de libros
				// Primero, recuperamos todos los datos del formulario
				// Ahora insertamos el libro en la BD
				$result = $this->instalacion->insert($nombre, $descripcion, $imagen, $precio);

				// Lanzamos el INSERT contra la BD.
				if ($result == 1) {
					// Tenemos que averiguar que idUsuario se ha asignado a la incidencia que acabamos de insertar
					$ultimoId = $this->instalacion->getLastId();
					$data['msjInfo'] = "Instalacion insertada con exito";
				} else {
					// Si la insercion de la incidencia ha fallado, mostramos mensaje de error
					$data['msjError'] = "Ha ocurrido un error al insertar la instalacion. Por favor, intentelo mas tarde.";
				}
				$data['listaInstalaciones'] = $this->instalacion->getAll();
				$this->vista->mostrar("instalacion/mostrarInstalaciones", $data);

			}else {
				$this->seguridad->errorAccesoNoPermitido();
			}	
		}

		// --------------------------------- BORRAR Instalaciones ----------------------------------------

        /*public function borrarIncidencia() {
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
*/
		// --------------------Elimina una Instalacion de la base de datos (petición por ajax)----------------------------

	public function borrarInstalacionAjax(){

		if ($this->seguridad->haySesionIniciada()) {
			// Recuperamos el id de la Instalacion
			$id = $_REQUEST["id"];
			// Eliminamos la Instalacion de la BD
			$result = $this->instalacion->delete($id);
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

		// --------------------------------- FORMULARIO MODIFICAR Instalaciones ----------------------------------------

		public function formularioModificarInstalacion() {
			if ($this->seguridad->haySesionIniciada()) {

				$idUsuario = $_SESSION["id"];
				$id = $_REQUEST["id"];
				$data['instalacion'] = $this->instalacion->get($id);
				$this->vista->mostrar('instalacion/formularioModificarInstalacion', $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
		}

		// --------------------------------- MODIFICAR INCIDENCIAS ----------------------------------------

		public function modificarInstalacion() {

			if ($this->seguridad->haySesionIniciada()) {

				//lanzamos la consulta pa la bd
				$result = $this->instalacion->update();
				
				if ($result == 1) {
				// Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
					$data['msjInfo'] = "Instalacion actualizada con éxito";
				}else {
					$data['msjError'] = "Error al actualizar la Instalacion";
				}
				$data['listaInstalaciones'] = $this->instalacion->getAll();
				$this->vista->mostrar("instalacion/mostrarInstalaciones", $data);
			} else {
				$this->seguridad->errorAccesoNoPermitido();
			}
		}

		// --------------------------------- BUSCAR Instalaciones ----------------------------------------

        public function buscarInstalacion() {
			// Recuperamos el texto de b�squeda de la variable de formulario
			$textoBusqueda = $_REQUEST["textoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de incidencas
			$data['listaInstalaciones'] = $this->instalacion->busquedaAproximada($textoBusqueda);
			$data['msjInfo'] = "Resultados de la búsqueda: \"$textoBusqueda\"";
			$this->vista->mostrar("instalacion/mostrarInstalaciones", $data);
		}

		// ---------------------------------- CAMBIAR VALOR DE ORDENACION INCIDENCIAS--------------------------------

		public function tipoBusquedaInstalacion(){
			// Recuperamos el texto de búsqueda de la variable de formulario
			$tipoBusqueda = $_REQUEST["tipoBusqueda"];
			// Lanzamos la búsqueda y enviamos los resultados a la vista de lista de incidencias
			$data['listaInstalaciones'] = $this->instalacion->getOrder($tipoBusqueda);
			$data['msjInfo'] = "Busquedas ordenadas por: \"$tipoBusqueda\"";
			$this->vista->mostrar("instalacion/mostrarInstalaciones", $data);
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

				$id = $_REQUEST["id"];
				$data['usuario'] = $this->usuario->get($id);
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
