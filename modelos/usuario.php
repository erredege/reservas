<?php
     include_once("DB.php");

    class Usuario {
        private $db;

        public function __construct() {
            $this->db = new DB;
        }

        public function buscarUsuario($email,$password) {

            $usuario = $this->db->consulta("SELECT id, email, nombre, tipo FROM usuarios WHERE email = '$email' AND password = '$password'");
            
            if ($usuario){
                return $usuario;
            }else {
                return null;
            }

        }

        public function get($id) {
            
            $result = $this->db->consulta("SELECT * FROM usuarios WHERE usuarios.id = '$id'");
           
            return $result;

        }

        public function getAll() {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM usuarios");
            
            return $result;

        }

        public function getOrder($tipoBusqueda) {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM usuarios ORDER BY usuarios.$tipoBusqueda");
            
            return $result;
        }

        public function insert() {

            $email = $_REQUEST["email"];
            $password = $_REQUEST["password"];
            $nombre = $_REQUEST["nombre"];
            $apellido1 = $_REQUEST["apellido1"];
            $apellido2 = $_REQUEST["apellido2"];
            $dni = $_REQUEST["dni"];
            $tipo = $_REQUEST["tipo"];
            $dir_subida = 'imgs/usuario/';
            $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                $result = $this->db->manipulacion("INSERT INTO usuarios (email,password,nombre,apellido1,apellido2,dni,imagen,tipo) 
                        VALUES ('$email', '$password', '$nombre', '$apellido1', '$apellido2', '$dni', '$fichero_subido', '$tipo')");        
            } else {
                 $result = -1;
            }

            
            return $result;
        }

        public function update() {

            $id = $_REQUEST["id"];
            $email = $_REQUEST["email"];
            $password = $_REQUEST["password"];
            $nombre = $_REQUEST["nombre"];
            $apellido1 = $_REQUEST["apellido1"];
            $apellido2 = $_REQUEST["apellido2"];
            $dni = $_REQUEST["dni"];
            $tipo = $_REQUEST["tipo"];
            $dir_subida = 'imgs/usuario/';
            $fichero_subido = $dir_subida . basename($_FILES['imagen']['name']);

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                $result = $this->db->manipulacion("UPDATE usuarios SET email = '$email', password = '$password', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', dni = '$dni', imagen = '$fichero_subido', tipo = '$tipo' WHERE id = '$id'");
            } else {
                 $result = -1;
            }
            return $result;
        }

        public function delete($id) {
            $result = $this->db->manipulacion("DELETE FROM usuarios WHERE id = '$id'");
            return $result;
        }

        public function getLastId() {
            $result = $this->db->consulta("SELECT MAX(id) AS ultimoId FROM usuarios");
            $id = $result->ultimoId;
            return $id;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            $result = $this->db->consulta("SELECT * FROM usuarios
                        WHERE usuarios.id LIKE '%$textoBusqueda%'
                        OR usuarios.email LIKE '%$textoBusqueda%'
                        OR usuarios.nombre LIKE '%$textoBusqueda%'
                        OR usuarios.apellido1 LIKE '%$textoBusqueda%'
                        OR usuarios.apellido2 LIKE '%$textoBusqueda%'
                        OR usuarios.dni LIKE '%$textoBusqueda%'
                        OR usuarios.tipo LIKE '%$textoBusqueda%'
                        ORDER BY usuarios.id");

            return $result;
        }

        public function existeNombre($nombre) {
            $result = $this->db->consulta("SELECT * FROM usuarios WHERE nombre = '$nombre'");
            if ($result != null)
                return 1;
            else  
                return 0;

        }
    }
