<?php
     include_once("DB.php");

    class Instalacion {
        private $db;

        public function __construct() {
            $this->db = new DB;
        }

        public function get($id) {
            
            $result = $this->db->consulta("SELECT * FROM reservas WHERE reservas.id = '$id'");
           
            return $result;

        }

        public function getAll() {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM reservas");
            
            return $result;

        }

        public function getOrder($tipoBusqueda) {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM reservas ORDER BY reservas.$tipoBusqueda");
            
            return $result;
        }

        public function insert() {

            $fecha = $_REQUEST["fecha"];
            $hora = $_REQUEST["hora"];
            $precio = $_REQUEST["precio"];
	
            $result = $this->db->manipulacion("INSERT INTO reservas (fecha,hora,precio) VALUES ('$fecha', '$hora', '$precio'')"; 

            return $result;
        }

        public function update() {

            $id = $_REQUEST["id"];
            $fecha = $_REQUEST["fecha"];
            $hora = $_REQUEST["hora"];
            $precio = $_REQUEST["precio"];
            
            $result = $this->db->manipulacion("UPDATE reservas SET fecha = '$fecha', hora = '$hora', precio = '$precio' WHERE id = '$id'");

            return $result;
        }

        public function delete($id) {
            $result = $this->db->manipulacion("DELETE FROM reservas WHERE id = '$id'");
            return $result;
        }

        public function getLastId() {
            $result = $this->db->consulta("SELECT MAX(id) AS ultimoId FROM reservas");
            $id = $result->ultimoId;
            return $id;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            $result = $this->db->consulta("SELECT * FROM reservas
                        WHERE reservas.id LIKE '%$textoBusqueda%'
                        OR reservas.nombre LIKE '%$textoBusqueda%'
                        OR reservas.descripcion LIKE '%$textoBusqueda%'
                        OR reservas.precio LIKE '%$textoBusqueda%'
                        ORDER BY reservas.id");
            
            return $result;
        }
    }
