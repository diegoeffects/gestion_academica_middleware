<?php

	# SOAP ESTUDIANTES

	$operacion = $_GET["operacion"];

    try{
		//$wsdl_url = 'http://localhost:8080/JAXWS-SSDD/estudiantes?wsdl';
		$wsdl_url = 'https://gestion-academica-soap.herokuapp.com/estudiantes?wsdl';
		
        $soapClient = new SOAPClient($wsdl_url);
		
		# OPERACION traerInscripciones
		if($operacion == "traerInscripciones"){
			
			$resultado = $soapClient->traerInscripciones();
			
			header("Content-Type: application/json");
			echo json_encode($resultado->{'return'});
			
		}
		# OPERACION traerInscripcionesPorEstudiante
		elseif($operacion == "traerInscripcionesPorEstudiante"){

			if(isset($_GET["idUsuario"])){
				$idUsuario = $_GET["idUsuario"];
			}
			else{
				$idUsuario = 99999;
			}

			$parametros = array(
				'idUsuario' => $idUsuario,
			);
			
			$resultado = $soapClient->traerInscripcionesPorEstudiante($parametros);
			
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
			
			$resultado = $soapClient->traerMateriasPorInscripcionPorCarrera($parametros);
			
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
			
			$resultado = $soapClient->altaInscripcionEstudiante($parametros);
			
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
			
			$resultado = $soapClient->bajaInscripcionEstudiante($parametros);
			
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
			
			$parametros = array(
				'idUsuario' => $idUsuario,
				'correo' => $correo,
				'celular' => $celular,
			);
			
			$resultado = $soapClient->actualizarDatosUsuario($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);
			
		}
		# OPERACION actualizarDatosEstudianteAdministrador
		elseif($operacion == "actualizarDatosUsuarioPorAdministrador"){

			if(isset($_GET["idUsuario"])){
				$idUsuario = $_GET["idUsuario"];
			}
			else{
				$idUsuario = 99999;
			}

			if(isset($_GET["nombre"])){
				$nombre = $_GET["nombre"];
			}
			else{
				$nombre = "";
			}

			if(isset($_GET["apellido"])){
				$apellido = $_GET["apellido"];
			}
			else{
				$apellido = "";
			}

			if(isset($_GET["dni"])){
				$dni = $_GET["dni"];
			}
			else{
				$dni = "";
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
			
			$parametros = array(
				'idUsuario' => $idUsuario,
				'nombre' => $nombre,
				'apellido' => $apellido,
				'dni' => $dni,
				'correo' => $correo,
				'celular' => $celular,
			);
			
			$resultado = $soapClient->actualizarDatosUsuarioPorAdministrador($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);
			
		}
    }
    catch(Exception $ex){
        echo "Exception ocurred: " . $ex;
    }

?>