<?php
     include_once("DB.php");

    class Instalacion {
        private $db;

        public function __construct() {
            $this->db = new DB;
        }

        public function get($id) {
            
            $result = $this->db->consulta("SELECT * FROM instalaciones WHERE instalaciones.id = '$id'");
           
            return $result;

        }

        public function getAll() {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM instalaciones");
            
            return $result;

        }

        public function getOrder($tipoBusqueda) {
            $arrayResult = array();
            $result = $this->db->consulta("SELECT * FROM instalaciones ORDER BY instalaciones.$tipoBusqueda");
            
            return $result;
        }

        public function insert() {

            $nombre = $_REQUEST["nombre"];
            $descripcion = $_REQUEST["descripcion"];
            $precio = $_REQUEST["precio"];
            $imagen = $_REQUEST["imagen"];

            $result = $this->db->manipulacion("INSERT INTO instalaciones (nombre,descripcion,precio,imagen) 
                        VALUES ('$nombre', '$descripcion', '$precio', '$imagen')");        
            
            return $result;
        }

        public function update() {

            $id = $_REQUEST["id"];
            $nombre = $_REQUEST["nombre"];
            $descripcion = $_REQUEST["descripcion"];
            $precio = $_REQUEST["precio"];
            $imagen = $_REQUEST["imagen"];

            $result = $this->db->manipulacion("UPDATE instalaciones SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio', imagen = '$imagen' WHERE id = '$id'");
            return $result;
        }

        public function delete($id) {
            $result = $this->db->manipulacion("DELETE FROM instalaciones WHERE id = '$id'");
            return $result;
        }

        public function getLastId() {
            $result = $this->db->consulta("SELECT MAX(id) AS ultimoId FROM instalaciones");
            $id = $result->ultimoId;
            return $id;
        }

        public function busquedaAproximada($textoBusqueda) {
            $arrayResult = array();
            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda

            $result = $this->db->consulta("SELECT * FROM instalaciones
                        WHERE instalaciones.id LIKE '%$textoBusqueda%'
                        OR instalaciones.nombre LIKE '%$textoBusqueda%'
                        OR instalaciones.descripcion LIKE '%$textoBusqueda%'
                        OR instalaciones.precio LIKE '%$textoBusqueda%'
                        ORDER BY instalaciones.id");
            
            return $result;
        }
    }
