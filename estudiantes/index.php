<?php

	# SOAP ESTUDIANTES

	include("acciones/EstudiantesController.php");

	if (isset($_GET["operacion"])) {
		$operacion = $_GET["operacion"];
	}
	else {
		$operacion = "";
	}

	# OPERACION traerInscripcionesActivas
	if ($operacion == "traerInscripcionesActivas") {
	
		$resultado = traerInscripcionesActivas();

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($resultado->{'return'});
		
	}
	# OPERACION traerInscripcionesPorEstudiante
	elseif ($operacion == "traerInscripcionesPorEstudiante") {

		if (isset($_GET["idUsuario"])) {
			$idUsuario = $_GET["idUsuario"];
		}
		else {
			$idUsuario = 99999;
		}

		$parametros = array(
			'idUsuario' => $idUsuario,
		);

		$resultado = traerInscripcionesPorEstudiante($parametros);
		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($resultado);
		
	}
	# OPERACION traerMateriasPorInscripcionPorCarrera
	elseif($operacion == "traerMateriasPorInscripcionPorCarrera"){

		if(isset($_GET["idInscripcion"])){
			$idInscripcion = $_GET["idInscripcion"];
		}
		else{
			$idInscripcion = 99999;
		}

		if(isset($_GET["idCarrera"])){
			$idCarrera = $_GET["idCarrera"];
		}
		else{
			$idCarrera = 99999;
		}
		
		$parametros = array(
			'idInscripcion' => $idInscripcion,
			'idCarrera' => $idCarrera,
		);
		
		$resultado = traerMateriasPorInscripcionPorCarrera($parametros);
		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($resultado);
		
	}
	# OPERACION altaInscripcionEstudiante	
	elseif($operacion == "altaInscripcionEstudiante"){

		if(isset($_GET["idUsuario"])){
			$idUsuario = $_GET["idUsuario"];
		}
		else{
			$idUsuario = 99999;
		}

		if(isset($_GET["idInscripcion"])){
			$idInscripcion = $_GET["idInscripcion"];
		}
		else{
			$idInscripcion = 99999;
		}

		if(isset($_GET["idComision"])){
			$idComision = $_GET["idComision"];
		}
		else{
			$idComision = 99999;
		}

		$parametros = array(
			'idUsuario' => $idUsuario,
			'idInscripcion' => $idInscripcion,
			'idComision' => $idComision,
		);
		
		$resultado = altaInscripcionEstudiante($parametros);
		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($resultado);
		
	}
	# OPERACION bajaInscripcionEstudiante
	elseif($operacion == "bajaInscripcionEstudiante"){

		if(isset($_GET["idDetalleInscripcion"])){
			$idDetalleInscripcion = $_GET["idDetalleInscripcion"];
		}
		else{
			$idDetalleInscripcion = 99999;
		}
		
		$parametros = array(
			'idDetalleInscripcion' => $idDetalleInscripcion,
		);
		
		$resultado = bajaInscripcionEstudiante($parametros);
		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($resultado);
		
	}
	# OPERACION actualizarDatosEstudiante
	elseif($operacion == "actualizarDatosUsuario"){

		if(isset($_GET["idUsuario"])){
			$idUsuario = $_GET["idUsuario"];
		}
		else{
			$idUsuario = 99999;
		}

		if(isset($_GET["correo"])){
			$correo = $_GET["correo"];
		}
		else{
			$correo = "";
		}
	
		if(isset($_GET["celular"])){
			$celular = $_GET["celular"];
		}
		else{
			$celular = "";
		}

		if(isset($_GET["clave"])){
			$clave = $_GET["clave"];
		}
		else{
			$clave = "";
		}
		
		$parametros = array(
			'idUsuario' => $idUsuario,
			'correo' => $correo,
			'celular' => $celular,
			'clave' => $clave,
		);
		
		$resultado = actualizarDatosUsuario($parametros);
		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($resultado);
		
	}
	elseif($operacion == ""){
		$params = array(
			'error' => 'No se especifico ninguna operacion valida',
			'estado' => 'FAIL',
		);
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
		header("Content-Type: application/json");
		echo json_encode($params);
	}

?>