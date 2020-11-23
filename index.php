<?php

	//iniciamos sesion
	session_start();
	
	// Creamos los objetos vista y modelos
	include_once("controlador.php");
	$controlador = new Controlador();
	
	if (isset($_REQUEST["action"])) {
		$action = $_REQUEST["action"];
	} else {
		$action = "mostrarFormularioLogin";  // Accion por defecto
	}

	$controlador->$action();