<?php
    class Seguridad {

        public function abrirSesion($usuario) {
            $_SESSION["id"] = $usuario->id;
            $_SESSION["email"] = $usuario->email;
            $_SESSION["nombre"] = $usuario->nombre;
            $_SESSION["tipo"] = $usuario->tipo;
        }

        public function cerrarSesion() {
            session_destroy();
        }

        public function get($variable) {
            return $_SESSION[$variable];
        }

        public function haySesionIniciada() {
            if (isset($_SESSION["id"])) {
                return true;
            } else {
                return false;
            }
        }

        public function errorAccesoNoPermitido() {
			$data['msjError'] = "No tienes permisos para hacer eso";
			$this->vista->mostrar("usuario/formularioLogin", $data);
        }
    }