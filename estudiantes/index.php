<?php

	# SOAP ESTUIANTES

	$operacion = $_GET["operacion"];

    try{
        //$wsdl_url = 'http://localhost:1515/ws/estudiantes?wsdl';
		$wsdl_url = 'http://localhost:8080/JAXWS-SSDD/estudiantes?wsdl';
		//$wsdl_url = 'https://gestion-academica-soap.herokuapp.com/estudiantes?wsdl';
		
        $soapClient = new SOAPClient($wsdl_url);
		
		# OPERACION traerInscripciones
		if($operacion == "traerInscripciones"){
			
			$resultado = $soapClient->traerInscripciones();
			
			header("Content-Type: application/json");
			echo json_encode($resultado->{'return'});
			
		}
		# OPERACION traerDetallesInscripcionPorEstudiante
		elseif($operacion == "traerDetallesInscripcionPorEstudiante"){
			
			$idUsuario = $_GET["idUsuario"];
			
			$parametros = array(
				'idUsuario' => $idUsuario,
			);
			
			$resultado = $soapClient->traerDetallesInscripcionPorEstudiante($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);
			
		}
		# OPERACION traerMateriasPorInscripcionPorCarrera
		elseif($operacion == "traerMateriasPorInscripcionPorCarrera"){
			
			$idInscripcion = $_GET["idInscripcion"];
			$idCarrera = $_GET["idCarrera"];
			
			$parametros = array(
				'idInscripcion' => $idInscripcion,
				'idCarrera' => $idCarrera,
			);
			
			$resultado = $soapClient->traerMateriasPorInscripcionPorCarrera($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);
			
		}
		# OPERACION agregarDetalleInscripcion	
		elseif($operacion == "agregarDetalleInscripcion"){
			
			$idUsuario = $_GET["idUsuario"];
			$idInscripcion = $_GET["idInscripcion"];
			$idComision = $_GET["idComision"];
			
			$parametros = array(
				'idUsuario' => $idUsuario,
				'idInscripcion' => $idInscripcion,
				'idComision' => $idComision,
			);
			
			$resultado = $soapClient->agregarDetalleInscripcion($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);	
			
		}
		# OPERACION bajaDetalleInscripcion
		elseif($operacion == "bajaDetalleInscripcion"){
			
			$idDetalleInscripcion = $_GET["idDetalleInscripcion"];
			
			$parametros = array(
				'idDetalleInscripcion' => $idDetalleInscripcion,
			);
			
			$resultado = $soapClient->bajaDetalleInscripcion($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);
			
		}
		# OPERACION actualizarDatosEstudiante
		elseif($operacion == "actualizarDatosUsuario"){
			
			$idUsuario = $_GET["idUsuario"];
			$correo = $_GET["correo"];
			$celular = $_GET["celular"];
			
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
			
			$idUsuario = $_GET["idUsuario"];
			$nombre = $_GET["nombre"];
			$apellido = $_GET["apellido"];
			$dni = $_GET["dni"];
			$correo = $_GET["correo"];
			$celular = $_GET["celular"];
			
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