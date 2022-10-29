<?php

	# SOAP REPORTES

	if(isset($_GET["operacion"])){
		$operacion = $_GET["operacion"];
	}
	else{
		$operacion = "";
	}
	
    try{
		//$wsdl_url = 'http://localhost:8080/JAXWS-SSDD/reportes?wsdl';
		$wsdl_url = 'https://gestion-academica-soap.herokuapp.com/reportes?wsdl';
		
        $soapClient = new SOAPClient($wsdl_url);
	
		# REPORTE ANALITICO DE ESTUDIANTE
		# OPERACION traerMateriasAprobadasPorEstudiante
		if($operacion == "traerMateriasAprobadasPorEstudiante"){

			if(isset($_GET["idUsuario"])){
				$idUsuario = $_GET["idUsuario"];
			}
			else{
				$idUsuario = 99999;
			}

			$parametros = array(
				'idUsuario' => $idUsuario
			);
			$materiasAprobadasWS = $soapClient->traerMateriasAprobadasPorEstudiante($parametros);
			
			if( isset($materiasAprobadasWS->{'return'}) ){
				$materiasAprobadas = $materiasAprobadasWS->{'return'};
				require_once('acciones/generarAnaliticoEstudiantePDF.php');
			}
			else{
				$params = array(
					'mensaje' => 'Error',
				);
				header("Content-Type: application/json");
				echo json_encode($params);
			}

		}
		# REPORTE LISTADO DE ESTUDIANTES INSCRIPTOS
		# OPERACION traerEstudiantesInscriptosPorMateria
		elseif($operacion == "traerEstudiantesInscriptosPorMateria"){

			if(isset($_GET["idComision"])){
				$idComision = $_GET["idComision"];
			}
			else{
				$idComision = 99999;
			}

			$parametros = array(
				'idComision' => $idComision
			);

			$estudiantesInscriptosWS = $soapClient->traerEstudiantesInscriptosPorMateria($parametros);
			
			if( isset($estudiantesInscriptosWS->{'return'}) ){
				$estudiantesInscriptos = $estudiantesInscriptosWS->{'return'};
				require_once('acciones/generarListadoInscriptosExcel.php');
			}
			else{
				$params = array(
					'mensaje' => 'Error',
				);
				header("Content-Type: application/json");
				echo json_encode($params);
			}

		}
		# REPORTE LISTADO DE MATERIAS
		# OPERACION traerMateriasPorInscripcionYCarreraYTurno
		elseif($operacion == "traerMateriasPorInscripcionYCarreraYTurno"){

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
			if(isset($_GET["idTurno"])){
				$idTurno = $_GET["idTurno"];
			}
			else{
				$idTurno = 99999;
			}
			
			$parametros = array(
				'idInscripcion' => $idInscripcion,
				'idCarrera' => $idCarrera,
				'idTurno' => $idTurno
			);

			$materiasWS = $soapClient->traerMateriasPorInscripcionYCarreraYTurno($parametros);
			
			if( isset($materiasWS->{'return'}) ){
				$materiasInscripcion = $materiasWS->{'return'};
				require_once('acciones/generarPlanillaMateriasPDF.php');
			}
			else{
				$params = array(
					'mensaje' => 'Error',
				);
				header("Content-Type: application/json");
				echo json_encode($params);
			}
			
		}
		# REPORTE LISTADO DE COMISIONES POR INSTANCIA Y MATERIA
		# OPERACION traerComisionesPorInstanciaYMateria
		elseif($operacion == "traerComisionesPorInstanciaYMateria"){

			if(isset($_GET["idInstancia"])){
				$idInstancia = $_GET["idInstancia"];
			}
			else{
				$idInstancia = 99999;
			}
			if(isset($_GET["idMateria"])){
				$idMateria = $_GET["idMateria"];
			}
			else{
				$idMateria = 99999;
			}
			
			$parametros = array(
				'idInstancia' => $idInstancia,
				'idMateria' => $idMateria
			);

			$resultado = $soapClient->traerComisionesPorInstanciaYMateria($parametros);
			
			header("Content-Type: application/json");
			echo json_encode($resultado);
			
		}
		elseif($operacion == ""){
			echo "ATENCION: No se especifico ninguna operación valida";
		}
		
    }
    catch(Exception $ex){
        echo "Exception ocurred: " . $ex;
    }

?>